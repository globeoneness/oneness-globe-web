# Energetic corporate/documentary score (124 BPM) + SFX, generated in code and aligned to timeline.json -> music.wav
import json, numpy as np, wave
from scipy.signal import butter, sosfilt, fftconvolve
tl=json.load(open('timeline.json')); D=tl['D']; st={s['id']:s['start'] for s in tl['S']}
sr=44100; n=int(sr*(D+1)); L=np.zeros(n); R=np.zeros(n); rng=np.random.default_rng(3)
BPM=124; b=60/BPM; bar=4*b
f=lambda m:440*2**((m-69)/12)
def put(t,x,pan=.5,g=1.):
    i=int(t*sr)
    if i>=n: return
    x=x[:n-i]; L[i:i+len(x)]+=x*g*np.sqrt(1-pan); R[i:i+len(x)]+=x*g*np.sqrt(pan)
def T(d): return np.arange(int(d*sr))/sr
def kick():
    t=T(.35); return np.sin(2*np.pi*(48+110*np.exp(-t*28))*t)*np.exp(-t*9)+0.3*np.sin(2*np.pi*(48+110*np.exp(-t*28))*t)*np.exp(-t*40)
def noise(d,lo,hi,dec):
    t=T(d); x=sosfilt(butter(2,[lo,hi],'bandpass',fs=sr,output='sos'),rng.standard_normal(len(t))); return x*np.exp(-t*dec)
def clap(): return noise(.25,900,5000,18)*1.4
def hat(op=False): return noise(.3 if op else .06,6000,15000,8 if op else 70)*.5
def saw(m,d,amp,cut=2500,dec=None):
    t=T(d); ph=(f(m)*t)%1; x=2*ph-1; x+=(2*((f(m)*1.006*t)%1)-1)
    x=sosfilt(butter(2,cut,'low',fs=sr,output='sos'),x)*.5
    env=np.exp(-t*dec) if dec else np.minimum(1,t/.01)*np.minimum(1,(d-t)/.05)
    return x*env*amp
def pad(m,d,amp):
    t=T(d); x=sum(np.sin(2*np.pi*f(m)*k*t+rng.random()*6) for k in (.996,1,1.004))/3
    return x*np.minimum(1,t/.4)*np.minimum(1,(d-t)/.5)*amp
def riser(d,amp):
    t=T(d); x=sosfilt(butter(2,[500,8000],'bandpass',fs=sr,output='sos'),rng.standard_normal(len(t)))*.6
    x+=np.sin(2*np.pi*np.cumsum(300+2500*(t/d)**2)/sr)*.2; return x*(t/d)**2.2*amp
def boom(amp): t=T(2.5); return (np.sin(2*np.pi*(40+70*np.exp(-t*6))*t)*np.exp(-t*1.8)+noise(2.5,60,900,3)*.4)*amp
def whoosh(amp): t=T(.7); x=sosfilt(butter(2,[700,7000],'bandpass',fs=sr,output='sos'),rng.standard_normal(len(t))); return x*np.sin(np.pi*t/.7)**2*amp
# sections: intro (A), tension (B-D, minor, half drums), drop at E (major, full), outro at R
minor=[[47,54,59,62],[43,50,55,59],[45,52,57,61],[42,49,54,58]]   # Bm G A F#m
major=[[50,57,62,66],[47,54,59,62],[43,50,55,59],[45,52,57,61]]   # D Bm G A
def section(a,z,prog,level):
    t=a; k=0
    while t<z-0.01:
        ch=prog[k%4]; dur=min(bar,z-t)
        for m in ch[1:]: put(t,pad(m+12,dur+.3,.035),pan=.3+.4*rng.random())
        for i in range(8):                                   # driving 8th bass
            tt=t+i*b/2
            if tt<z: put(tt,saw(ch[0]-12+(12 if i%2 and level>1 else 0),b/2*.9,.16,cut=900),g=1)
        if level>=1:
            for i in range(16):                              # 16th pluck arpeggio
                tt=t+i*b/4
                if tt<z: put(tt,saw(ch[[1,2,3,2][i%4]]+12+(12 if (i//4)%2 else 0),.25,.05,cut=3500,dec=14),pan=.2+.6*(i%2))
        for i in range(4):
            tt=t+i*b
            if tt>=z: break
            if level>=1: put(tt,kick(),g=.9)
            if level>=2 and i%2: put(tt,clap(),pan=.5,g=.55)
            put(tt+b/2,hat(level>=2),pan=.65,g=.5 if level>=2 else .35)
            if level>=2: put(tt+b/4,hat(),pan=.35,g=.25); put(tt+3*b/4,hat(),pan=.35,g=.25)
        t+=bar; k+=1
section(0,st['B'],minor,0)
section(st['B'],st['E'],minor,1)
section(st['E'],st['R'],major,2)
section(st['R'],D+.5,major,1)
put(st['E']-2*bar/2,riser(bar,.25)); put(st['E'],boom(.6)); put(st['L'],boom(.3)); put(st['R'],boom(.5)); put(0.05,boom(.35))
put(st['L']-bar/2,riser(bar/2,.15)); put(st['R']-bar/2,riser(bar/2,.18))
for s in tl['S'][1:]: put(s['start']-.35,whoosh(.07))
x=np.stack([L,R],1)
ir=rng.standard_normal((int(1.2*sr),2))*np.exp(-np.arange(int(1.2*sr))/sr*4)[:,None]*.04
x=x+np.stack([fftconvolve(x[:,c],ir[:,c])[:n] for c in range(2)],1)*.5
t=np.arange(n)/sr; x*=np.clip(np.minimum(t/0.3,(D+1-t)/1.5),0,1)[:,None]
x=np.tanh(x/np.abs(x).max()*1.6)/np.tanh(1.6)*.9          # gentle saturation for punch
w=wave.open('music.wav','wb');w.setnchannels(2);w.setsampwidth(2);w.setframerate(sr);w.writeframes((x*32767).astype('<i2').tobytes());w.close()
print('music ok',round(D,1))
