# Writes narration.srt (Bengali voice-over timing) from timeline.json
import json
tl=json.load(open('timeline.json'))
def ts(x):h=int(x//3600);m=int(x%3600//60);s=x%60;return f"{h:02}:{m:02}:{int(s):02},{int(round((s%1)*1000)):03}"
out=[]
for i,(a,b,t,sid) in enumerate(tl['SUBS'],1): out.append(f"{i}\n{ts(a)} --> {ts(b)}\n{t}\n")
open('narration.srt','w',encoding='utf-8').write("\n".join(out)); print(len(out),'cues')
