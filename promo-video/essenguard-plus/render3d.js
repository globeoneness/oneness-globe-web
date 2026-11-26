// node render3d.js preview t1 t2 ... | node render3d.js frames <worker> <workers>
const {chromium}=require('playwright');const fs=require('fs');
(async()=>{const [mode,...a]=process.argv.slice(2);
 const b=await chromium.launch({args:['--use-gl=angle','--use-angle=swiftshader','--enable-unsafe-swiftshader','--ignore-gpu-blocklist']});
 const pg=await b.newPage({viewport:{width:1080,height:1920}});const errs=[];pg.on('pageerror',e=>errs.push(e.message));pg.on('console',m=>{if(m.type()==='error')errs.push(m.text())});
 await pg.goto('http://127.0.0.1:8765/video3d.html');await pg.waitForFunction(()=>window.LOADED===true,null,{timeout:120000});await pg.evaluate(()=>document.fonts.ready);await pg.waitForTimeout(800);
 const D=await pg.evaluate(()=>DURATION);
 if(mode==='preview'){fs.mkdirSync('prev',{recursive:true});for(const t of a.map(Number)){await pg.evaluate(t=>render(t),t);await pg.evaluate(t=>render(t),t);const t0=Date.now();await pg.evaluate(t=>render(t),t);await pg.screenshot({path:`prev/p_${t}.jpg`,type:'jpeg',quality:85});console.log(t,'ms',Date.now()-t0)}console.log('D',D,'errs',errs.slice(0,5));await b.close();return}
 const fps=30,N=Math.round(D*fps),[w,nw]=a.map(Number);fs.mkdirSync('frames',{recursive:true});
 for(let i=w;i<N;i+=nw){const fn=`frames/f${String(i).padStart(5,'0')}.jpg`;if(fs.existsSync(fn))continue;await pg.evaluate(t=>render(t),i/fps);await pg.screenshot({path:fn,type:'jpeg',quality:93})}
 console.log('done',w,errs.slice(0,3));await b.close()})();
