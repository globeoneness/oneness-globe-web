# ONENESS GLOBE — Theme v2.0.0 Verification Report

Scope: six product-detail pages, homepage, theme structure, and literature transcription against the six original PDFs.

## 1. What was delivered

| Item | File |
|---|---|
| Installable theme (replaces v1.8) | `dist/oneness-globe-wordpress-theme-v2.0.0.zip` |
| Interactive HTML preview | `preview/index.html` (open it in any browser; also in `dist/oneness-globe-preview.zip`) |
| This report | `VERIFICATION-REPORT.md` |
| Android install steps | `INSTALL-ANDROID.md` |

Nothing has been published to onenessglobe.com.

## 2. Problems found in the uploaded v1.8 ZIP

1. **The ZIP file is truncated.** It has no end-of-archive directory, so standard tools cannot open it. 21 of its 22 file entries could be recovered directly. The last entry (`livren-g-literature.webp`) is damaged and was regenerated from the PDF.
2. **Images missing from the package:** `logo.webp`, `product-3.webp`, `product-4.webp`, `heat-stress-pro.webp`. The theme pointed at them, so the logo and two product photos did not display. Photos and logo were restored from the company photos in the repository (`shop/images`, `assets/assets/logo.png`).
3. **Literature was not the original.** The v1.8 text was a summary with OCR errors, not the brochure. It has been rebuilt from the PDFs.
4. **Carton prices.** Cards showed carton-style "per pack" wording. Only the single-pack MRP is shown now.
5. **Wrong address in footer.** It read "Plot-212, Block-C … Chattogram". It now matches the brochure: "212/C, Bishow Bank Colony, Akborshah, Chattogram-4207, Bangladesh".
6. **Internal note on public page.** The footer said product descriptions "should be approved before publication". Removed from the public footer; this report and the admin-only notes carry that message instead.
7. **Structure.** The homepage was a standalone HTML document, not a WordPress template. It is now split into standard header, footer and page templates.
8. **Old links.** Product links used `/?og_product=…`. They now use `/products/{slug}/`, and the old links redirect permanently.

## 3. How the theme was tested — and what was not

**Tested in this environment:**
- PHP syntax check of all 9 PHP files: no errors.
- Routing: the rewrite rule `^products/([^/]+)/?$` matches all six product addresses and does not match `/products/`.
- Rendering: all templates were run to HTML through a small WordPress stand-in (`tools/render-preview.php`). This covers the home page, all six product pages, and an unknown product address (returns 404 page).
- Literature check: every value, ingredient, dosage line, precaution, company line and registration on each product page was compared with the data file. Result: all present on their pages. (One LivRen-G sentence containing an apostrophe was flagged by the checker only because of HTML escaping; the text is present and correct.)
- Browser tests (Chromium, phone 390 px and desktop 1280 px): no horizontal scrolling, no JavaScript errors, no failed requests, tap-to-zoom opens and closes, card tap opens the product, all six PDFs download as valid PDF files.
- Two layout faults found in these tests and fixed in v2.0.0: (a) v1.8 CSS enlarged product photos by 24–32%, cropping them inside the phone cards; (b) the zoom viewer was not wired on the first build. Both were re-tested after the fix.

**Not tested — please confirm on your staging copy or after installing:**
- **A real WordPress installation and Namecheap EasyWP.** WordPress itself could not be downloaded in this environment (blocked). Permalink flushing, the Customizer WhatsApp field and theme upload are verified by code review only.
- **WhatsApp opening on a phone.** Links are generated in the correct format (`https://wa.me/8801339562576?text=…`) but were not opened in the WhatsApp app.
- **Real Android and iPhone devices.** Phone layouts were tested in a phone-sized browser only.

## 4. Product-by-product checklist

Method: numbers and units were read at 600 dpi from the PDF artwork. Body text was read at full page scale and cross-checked with an OCR pass. Pack, price and pack-size values come from your brief.

| Product | Pack / MRP | Composition | Indications / benefits | Dosage | Storage, shelf life, withdrawal, origin | Company / registration | Status |
|---|---|---|---|---|---|---|---|
| ONE IMMUNE | 100 gm / ৳680 | 23 rows, verified at 600 dpi | 2 groups, 16 bullets | 2 rows, verified | Shelf life 3 years; withdrawal **not stated**; China | Vitboo; ONENESS GLOBE; DLS 1372 | Open items 1, 2 |
| Grow Pro | 100 gm / ৳530 | 4 groups, 24 rows, verified at 600 dpi | 10 bullets | 4 rows + note, verified | Shelf life 3 years; withdrawal 0 days; China | Vitboo; DLS 1372 | Open item 3 |
| EssenGuard™ Plus | 200 gm / ৳920 | **Ingredient names only, no quantities printed** | 6 benefit groups | 3 rows + note, verified | Shelf life 3 years; withdrawal: none required; China | Henan Muxiang; DLS 1372 | Open items 4, 5 |
| LivRen-G | 500 ml / ৳965 | 5 rows incl. "≥" values, verified at 600 dpi | 5 indication groups, 8 key benefits | 2 rows + note, verified | Shelf life 3 years; withdrawal N/A; China | Henan Muxiang; DLS 1372 | Verified |
| Optiacid | 500 ml / ৳715 | 8 rows, verified at 600 dpi | 7 key benefits | 2 rows, verified | Shelf life 3 years; withdrawal N/A; China | Henan Muxiang; DLS 1372 | Open item 6 |
| Mycoclean Plus | 200 gm / ৳835 | **Ingredient names only, no quantities printed** | 4 indications, 5 benefit groups | 2 rows + 3 notes, verified | Shelf life 3 years; withdrawal N/A; China | Henan Muxiang; DLS 1372 | Open items 7, 8, 9 |

### Literature shown on each page
- Brochure artwork (front and back panels) rendered from the original PDF at high resolution; zoom supported.
- Original PDF available as "Download PDF" (unchanged file, byte-identical to the upload).

## 5. Open items for the company to confirm

These are shown on the page **exactly as printed** (or noted), and are not corrected by us.

1. **ONE IMMUNE, probiotic counts.** The artwork prints `1×109 CFU/g` (Lactobacillus, Clostridium butyricum) and `5×10° CFU/g` / `1×10° CFU/g` (other probiotics). The exponents look inconsistent. Please confirm the intended values.
2. **ONE IMMUNE, withdrawal period.** Not printed on the literature. The page says "Not stated in the supplied literature."
3. **Grow Pro, dosage wording.** "During stress period dose may be doubled or Use as directed by a registered veterinarian." — shown as printed; wording may need editing.
4. **EssenGuard Plus, composition quantities.** The literature lists Thymol, Carvacrol, Cinnamaldehyde, Eugenol, Benzoic Acid, Citric Acid and Excipients q.s. with **no amounts**. Amounts are needed before the composition can be complete.
5. **EssenGuard Plus, withdrawal wording.** Printed as "None required…". Shown as printed.
6. **Optiacid, unit.** Printed as grams per 500 ml, including "Solvent 71 g". Please confirm the unit.
7. **Mycoclean Plus, pack size conflict.** The front panel prints "200G Net Weight"; the back panel prints "Packing: 500ml". The page shows **200 gm**, as in your brief. Please confirm.
8. **Mycoclean Plus, composition quantities.** Same as EssenGuard: ingredient names only.
9. **Mycoclean Plus, typo.** The artwork prints "gastrointeistnal stress". The page shows "gastrointestinal" (non-technical correction; please confirm).

Non-technical edits made (please approve or ask for reversal): a missing comma in ONE IMMUNE's description ("prebiotics, enzymes"); "Self Life" printed on the artwork is labelled "Shelf life".

## 6. Other notes

- **HEAT STRESS PRO:** no photograph was in any supplied file. The card shows "Photo to be supplied". No price or order button, as required.
- **Certifications:** GMP and ISO 9001 appear only as "Printed on pack artwork" text. No certification claim has been added.
- **Admin-only notes:** the open items above appear in a dashed box on each product page, visible only to logged-in administrators.
- **Prices:** exactly as in the brief (single-pack MRP only). No carton figures anywhere.
- **WhatsApp:** every order button uses +8801339562576 and a message naming the product, pack size, quantity of one single pack and MRP. Nothing is sent or paid until the customer taps Send in WhatsApp.
- **Aim, Mission, Vision text:** kept exactly as in v1.8. Please confirm before publication, as the v1.8 README asked.
