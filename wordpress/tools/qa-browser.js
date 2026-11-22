// Browser QA for the rendered preview: layout overflow, console/JS errors, broken assets,
// lightbox zoom, card navigation, and PDF downloads. Usage: node qa-browser.js <baseUrl> <outDir>
const { chromium } = require('playwright');
const base = process.argv[2];
const outDir = process.argv[3];
const slugs = ['one-immune', 'grow-pro', 'essenguard-plus', 'livren-g', 'optiacid', 'mycoclean-plus'];
const pages = [{ name: 'home', path: '/' }].concat(slugs.map(s => ({ name: s, path: `/products/${s}/` })));
const viewports = [{ name: 'phone', width: 390, height: 844 }, { name: 'desktop', width: 1280, height: 860 }];

(async () => {
  const browser = await chromium.launch();
  const report = { pages: [], cardNav: null, lightbox: null, pdfs: [] };
  for (const vp of viewports) {
    const ctx = await browser.newContext({ viewport: { width: vp.width, height: vp.height }, deviceScaleFactor: vp.name === 'phone' ? 2 : 1 });
    const page = await ctx.newPage();
    for (const pg of pages) {
      const errors = [];
      const failed = [];
      page.removeAllListeners('console'); page.removeAllListeners('pageerror'); page.removeAllListeners('response');
      page.on('console', m => { if (m.type() === 'error') errors.push(m.text()); });
      page.on('pageerror', e => errors.push('pageerror: ' + e.message));
      page.on('response', r => { if (r.status() >= 400) failed.push(r.status() + ' ' + r.url()); });
      await page.goto(base + pg.path, { waitUntil: 'load' });
      await page.waitForTimeout(300);
      await page.evaluate(async () => { for (let y = 0; y < document.body.scrollHeight; y += 600) { window.scrollTo(0, y); await new Promise(r => setTimeout(r, 60)); } window.scrollTo(0, 0); });
      await page.waitForFunction(() => [...document.images].filter(i => i.getAttribute('src')).every(i => i.complete), null, { timeout: 20000 }).catch(() => {});
      await page.waitForTimeout(200);
      const m = await page.evaluate(() => {
        const broken = [...document.images].filter(i => i.getAttribute('src') && (!i.complete || i.naturalWidth === 0)).map(i => i.getAttribute('src'));
        const overflow = document.documentElement.scrollWidth - document.documentElement.clientWidth;
        const wide = [...document.querySelectorAll('body *')].filter(el => {
          const r = el.getBoundingClientRect();
          return r.width > 0 && r.right > document.documentElement.clientWidth + 1 && getComputedStyle(el).position !== 'fixed' && !el.closest('.table-wrap') && !el.closest('dialog');
        }).slice(0, 5).map(el => el.tagName + '.' + el.className);
        const fonts = document.fonts ? document.fonts.status : 'n/a';
        return { title: document.title, broken, overflow, wide, h1: (document.querySelector('h1') || {}).textContent || null, sections: document.querySelectorAll('section').length };
      });
      if (pg.name !== 'home' && vp.name === 'desktop') {
        await page.screenshot({ path: `${outDir}/${pg.name}-${vp.name}-full.png`, fullPage: true });
      } else if (pg.name === 'home' || pg.name === 'one-immune' || pg.name === 'livren-g') {
        await page.screenshot({ path: `${outDir}/${pg.name}-${vp.name}-full.png`, fullPage: true });
      }
      report.pages.push({ viewport: vp.name, page: pg.name, title: m.title, h1: m.h1, sections: m.sections, horizontalOverflowPx: m.overflow, wideElements: m.wide, brokenImages: m.broken, consoleErrors: errors, failedRequests: failed });
    }
    await ctx.close();
  }

  // Card navigation: clicking the card body (not a link) opens that product page.
  const ctx = await browser.newContext({ viewport: { width: 390, height: 844 } });
  const p = await ctx.newPage();
  await p.goto(base + '/', { waitUntil: 'load' });
  const card = p.locator('article.product[data-product-url]').first();
  await card.locator('.product-kind').click();
  await p.waitForLoadState('load');
  report.cardNav = { clickedCardFirst: 'ONE IMMUNE', landed: p.url() };

  // Lightbox zoom on a product page.
  await p.goto(base + '/products/one-immune/', { waitUntil: 'load' });
  await p.locator('a.lit-zoom').scrollIntoViewIfNeeded();
  await p.locator('a.lit-zoom').click();
  await p.waitForTimeout(300);
  const open = await p.evaluate(() => document.getElementById('og-lightbox').open);
  const src = await p.evaluate(() => document.querySelector('#og-lightbox img').getAttribute('src'));
  await p.screenshot({ path: `${outDir}/lightbox-phone.png` });
  await p.locator('[data-og-lb-zoom]').click();
  const big = await p.evaluate(() => document.querySelector('#og-lightbox img').classList.contains('is-big'));
  await p.locator('[data-og-lb-close]').click();
  const closed = await p.evaluate(() => !document.getElementById('og-lightbox').open);
  report.lightbox = { opened: open, imageSrc: src, zoomToggles: big, closed };

  // PDFs: each original PDF must download with the PDF content type.
  for (const s of slugs) {
    const r = await p.request.get(`${base}/theme/assets/pdf/${s}-literature.pdf`);
    const body = await r.body();
    report.pdfs.push({ slug: s, status: r.status(), type: r.headers()['content-type'], pdfSignature: body.slice(0, 5).toString() === '%PDF-', bytes: body.length });
  }
  await ctx.close();
  await browser.close();
  console.log(JSON.stringify(report, null, 1));
})().catch(e => { console.error(e); process.exit(1); });
