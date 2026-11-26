// usage: node render.js preview  |  node render.js frames <worker> <nworkers> <dpr>
const {chromium}=require('playwright');const fs=require('fs');const path=require('path');
(async()=>{
 const [mode,w,nw,dprA]=process.argv.slice(2);const dpr=+(dprA||2);
 const b=await chromium.launch();const pg=await b.newPage({viewport:{width:1080,height:1920},deviceScaleFactor:mode==='preview'?1:dpr});
 const errs=[];pg.on('pageerror',e=>errs.push(e.message));
 await pg.goto('file://'+path.join(__dirname,'video.html'));await pg.evaluate(()=>document.fonts.ready);await pg.waitForTimeout(500);
 const info=await pg.evaluate(()=>({D:DURATION,S:SCENES,SUBS}));
 fs.writeFileSync('timeline.json',JSON.stringify(info,null,1));
 if(mode==='preview'){fs.mkdirSync('prev',{recursive:true});
   for(const s of info.S){for(const f of [.55,.92]){const t=s.start+(s.end-s.start)*f;await pg.evaluate(t=>render(t),t);await pg.screenshot({path:`prev/${s.id}_${f}.jpg`,type:'jpeg',quality:80})}}
   console.log('dur',info.D,'errors',errs);await b.close();return}
 const fps=30,N=Math.round(info.D*fps);fs.mkdirSync('frames',{recursive:true});
 for(let i=+w;i<N;i+=+nw){const fn=`frames/f${String(i).padStart(5,'0')}.jpg`;if(fs.existsSync(fn))continue;
   await pg.evaluate(t=>render(t),i/fps);await pg.screenshot({path:fn,type:'jpeg',quality:94});}
 console.log('worker',w,'done',errs);await b.close();
})();
