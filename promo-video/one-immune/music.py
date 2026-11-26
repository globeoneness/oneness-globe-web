# Generates music.wav: ambient scientific-documentary score + transition SFX, aligned to timeline.json
import json, numpy as np, wave
from scipy.signal import fftconvolve, butter, sosfilt
tl=json.load(open('timeline.json')); D=tl['D']; sc={s['id']:s for s in tl['S']}
sr=44100; n=int(sr*(D+0.5)); L=np.zeros(n); Rt=np.zeros(n); rng=np.random.default_rng(1)
f=lambda m:440*2**((m-69)/12)
def put(start,x,pan=.5,gain=1.):
    i=int(start*sr); x=x[:max(0,n-i)]; L[i:i+len(x)]+=x*gain*np.sqrt(1-pan); Rt[i:i+len(x)]+=x*gain*np.sqrt(pan)
def pad(m,dur,amp,bright=.3):
    t=np.arange(int(dur*sr))/sr; env=np.minimum(1,t/1.5)*np.minimum(1,(dur-t)/1.8)
    s=sum(np.sin(2*np.pi*f(m)*d*t+rng.random()*6) for d in (.996,1,1.004))/3
    s+=bright*np.sin(2*np.pi*2*f(m)*t)*(.5+.5*np.sin(2*np.pi*.2*t)); return s*env*amp
def pluck(m,amp,decay=3.5,dur=2.5):
    t=np.arange(int(dur*sr))/sr; env=np.exp(-t*decay)*np.minimum(1,t/.003)
    return (np.sin(2*np.pi*f(m)*t)+.4*np.sin(2*np.pi*2*f(m)*t)*np.exp(-t*6)+.15*np.sin(2*np.pi*3*f(m)*t)*np.exp(-t*9))*env*amp
def boom(amp):
    t=np.arange(int(3*sr))/sr; return np.sin(2*np.pi*(38+60*np.exp(-t*8))*t)*np.exp(-t*1.6)*amp
def whoosh(dur,amp,up=True):
    N=int(dur*sr); x=rng.standard_normal(N); t=np.linspace(0,1,N)
    sos=butter(2,[400,5000],'bandpass',fs=sr,output='sos'); x=sosfilt(sos,x)
    env=np.sin(np.pi*t)**2 if not up else t**2*(1-t**0.3)*4; return x*env*amp
def riser(dur,amp):
    N=int(dur*sr); t=np.arange(N)/sr; fr=200+1800*(t/dur)**2
    x=rng.standard_normal(N); sos=butter(2,[300,6000],'bandpass',fs=sr,output='sos'); x=sosfilt(sos,x)*.5+np.sin(2*np.pi*np.cumsum(fr)/sr)*.15
    return x*(t/dur)**2.5*amp
def ping(m,amp): return pluck(m,amp,decay=6,dur=1.5)
# chord sections
s=lambda k:sc[k]['start']
sections=[(0,s('E'),[[50,57,62,65],[46,53,58,62],[48,55,60,63],[45,52,57,61]],7.0,.05),     # Dm Bb Cm A (tense)
          (s('E'),s('L'),[[50,57,62,66],[47,54,59,62],[43,50,55,59],[45,52,57,61]],4.3,.045),# D Bm G A
          (s('L'),D,[[43,50,55,59],[50,57,62,66],[47,54,59,62],[45,52,57,61]],4.3,.05)]
for a,b,prog,bar,amp in sections:
    t=a;k=0
    while t<b:
        d=min(bar,b-t)+1.5; ch=prog[k%4]
        for m in ch: put(t,pad(m+12,d,amp),pan=.3+.4*rng.random())
        put(t,pad(ch[0]-12,d,amp*1.6,bright=0)); t+=bar;k+=1
# arpeggio pulse in science + indications
bpm=96; step=60/bpm/2; t=s('F'); i=0
arps={0:[62,66,69,74],1:[59,62,66,71],2:[55,59,62,67],3:[57,61,64,69]}
while t<s('R'):
    sec_i=int((t-s('E'))/4.3)%4; ch=arps[sec_i]; m=ch[i%4]+(12 if (i//4)%2 else 0)
    put(t,pluck(m,.05 if t<s('L') else .04),pan=.25+.5*(i%2)); i+=1; t+=step
# problem section: slow low piano notes
for j,t in enumerate(np.arange(0.5,s('E')-1,1.75)): put(t,pluck([62,65,69,65,60,62,57][j%7],.07,decay=1.5,dur=4),pan=.5)
# SFX
for k in [x['id'] for x in tl['S']][1:]: put(s(k)-.45,whoosh(.9,.05,up=False),pan=.5)
put(s('E')-3,riser(3,.12)); put(s('E'),boom(.5)); put(s('Q'),boom(.3)); put(s('R'),boom(.35)); put(0.1,boom(.25))
for k in ['G','H','I','J','K','M']: put(s(k)+.3,ping(86,.05),pan=.7)
x=np.stack([L,Rt],1)
ir_t=np.arange(int(2.2*sr))/sr; ir=rng.standard_normal((len(ir_t),2))*np.exp(-ir_t*2.6)[:,None]*.06
wet=np.stack([fftconvolve(x[:,c],ir[:,c])[:n] for c in range(2)],1)
y=x+wet*.6
fade=np.minimum(1,np.minimum(np.arange(n)/sr/0.8,(D+0.5-np.arange(n)/sr)/2.5))[:,None]
y*=np.clip(fade,0,1); y/=np.abs(y).max()/0.89
w=wave.open('music.wav','wb');w.setnchannels(2);w.setsampwidth(2);w.setframerate(sr);w.writeframes((y*32767).astype('<i2').tobytes());w.close()
print('ok',D)
