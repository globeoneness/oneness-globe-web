# EssenGuard Plus narration in the approved bold voice -> vo/S*.mp3, narration_full.wav, narration.srt
import subprocess,html,os,json
P='<prosody rate="+2%" pitch="-5%" range="+45%" volume="+40%" contour="(0%,+12%) (50%,+6%) (100%,-18%)">'
FX="highpass=f=70,equalizer=f=110:t=q:w=0.9:g=5,equalizer=f=350:t=q:w=1:g=-2.5,equalizer=f=2500:t=q:w=1:g=5,equalizer=f=6000:t=q:w=1:g=1.5,acompressor=threshold=0.06:ratio=6:attack=2:release=60:makeup=4,asoftclip=type=tanh:threshold=0.9"
EG="এসেনগার্ড প্লাস"
SC=[ # (scene, [(subtitle, spoken)]), shot length from PRODUCTION_PACK.md
 (1,22,[("পর্যাপ্ত খাদ্য গ্রহণের পরও প্রাণীর কাঙ্ক্ষিত বৃদ্ধি না হওয়া, হজমের সমস্যা, পাতলা পায়খানা এবং খাদ্যের অপচয়ের","পর্যাপ্ত খাদ্য গ্রহণের পরও প্রাণীর কাঙ্ক্ষিত বৃদ্ধি না হওয়া, হজমের সমস্যা, পাতলা পায়খানা এবং খাদ্যের অপচয়ের"),("অন্যতম কারণ হতে পারে অন্ত্রের মাইক্রোবিয়াল ভারসাম্যহীনতা।",None)]),
 (2,26,[("অন্ত্রে ক্ষতিকর ব্যাকটেরিয়ার আধিক্য হজম ও পুষ্টি শোষণের স্বাভাবিক কার্যক্রম ব্যাহত করতে পারে।",None),("ফলে খাদ্যের কার্যকর ব্যবহার এবং উৎপাদনশীলতা কমে যেতে পারে।",None)]),
 (3,20,[("EssenGuard Plus হলো মলিকিউলার-কোটেড এসেনশিয়াল অয়েল ও অর্গানিক অ্যাসিডের সমন্বয়ে তৈরি একটি অ্যান্টিবায়োটিকমুক্ত ফর্মুলেশন।",f"{EG} হলো, মলিকিউলার-কোটেড এসেনশিয়াল অয়েল ও অর্গানিক অ্যাসিডের সমন্বয়ে তৈরি, একটি অ্যান্টিবায়োটিকমুক্ত ফর্মুলেশন।")]),
 (4,30,[("থাইমল, কারভাক্রল ও ইউজেনলের মতো সক্রিয় উপাদান সংবেদনশীল ব্যাকটেরিয়ার কোষঝিল্লির কার্যক্রমে প্রভাব ফেলতে পারে।",None),("অর্গানিক অ্যাসিড ক্ষতিকর ব্যাকটেরিয়ার বৃদ্ধি নিয়ন্ত্রণে সহায়ক পরিবেশ তৈরিতে ভূমিকা রাখে।",None)]),
 (5,26,[("অন্ত্রের স্বাস্থ্য বজায় রাখা, ক্ষতিকর ব্যাকটেরিয়া নিয়ন্ত্রণে সহায়তা, খাদ্যের কার্যকর ব্যবহার",None),("এবং কাঙ্ক্ষিত উৎপাদনশীলতা অর্জনের উদ্দেশ্যে EssenGuard Plus ব্যবহার করা হয়।",f"এবং কাঙ্ক্ষিত উৎপাদনশীলতা অর্জনের উদ্দেশ্যে, {EG} ব্যবহার করা হয়।")]),
 (6,22,[("পোল্ট্রি ও শূকর: প্রতি কেজি খাদ্যে ০.৫–১ গ্রাম।","পোল্ট্রি ও শূকর: প্রতি কেজি খাদ্যে, শূন্য দশমিক পাঁচ থেকে এক গ্রাম।"),("গরু ও মহিষ: দৈনিক ২০–৪০ গ্রাম। বাছুর: দৈনিক ১০–২০ গ্রাম।","গরু ও মহিষ: দৈনিক বিশ থেকে চল্লিশ গ্রাম। বাছুর: দৈনিক দশ থেকে বিশ গ্রাম।"),
        ("প্রাপ্তবয়স্ক ছাগল ও ভেড়া: দৈনিক ৫–১০ গ্রাম। অল্পবয়সী ছাগল ও ভেড়া: দৈনিক ৩–৫ গ্রাম।","প্রাপ্তবয়স্ক ছাগল ও ভেড়া: দৈনিক পাঁচ থেকে দশ গ্রাম। অল্পবয়সী ছাগল ও ভেড়া: দৈনিক তিন থেকে পাঁচ গ্রাম।"),("খাদ্যের সাথে ভালোভাবে মিশিয়ে খাওয়ান।",None)]),
 (7,12,[("শুধুমাত্র প্রাণিচিকিৎসায় ব্যবহারের জন্য। রেজিস্টার্ড ভেটেরিনারি চিকিৎসকের পরামর্শ অনুযায়ী ব্যবহার করুন।",None)]),
]
os.makedirs("vo",exist_ok=True)
def tts(t,fn):
    ssml=f'<speak version="1.0" xml:lang="bn-BD"><voice name="bn-BD-PradeepNeural">{P}{html.escape(t)}</prosody></voice></speak>'
    r=subprocess.run(["curl","-s","-o",fn+".raw.mp3","-w","%{http_code}","-X","POST","https://centralindia.tts.speech.microsoft.com/cognitiveservices/v1","-H","Content-Type: application/ssml+xml","-H","X-Microsoft-OutputFormat: audio-48khz-192kbitrate-mono-mp3","-H","User-Agent: promo-video","--data-binary",ssml.encode()],capture_output=True,text=True)
    assert r.stdout=="200",r.stdout
    subprocess.run(["ffmpeg","-v","error","-y","-i",fn+".raw.mp3","-af",FX,"-ar","48000",fn],check=True); os.remove(fn+".raw.mp3")
dur=lambda f:float(subprocess.check_output(["ffprobe","-v","error","-show_entries","format=duration","-of","csv=p=0",f]))
t0=0;cues=[];place=[];report=[]
for sc,length,lines in SC:
    clips=[]
    for k,(sub,say) in enumerate(lines):
        fn=f"vo/S{sc}_{k}.wav"; tts(say or sub,fn); clips.append((sub,fn,dur(fn)))
    speech=sum(c[2] for c in clips)+0.35*(len(clips)-1); L=max(length,speech+1.2); x=t0+(L-speech)/2
    for sub,fn,d in clips: cues.append((x,x+d+.1,sub)); place.append((x,fn)); x+=d+.35
    report.append((sc,round(L,1),round(speech,1))); t0+=L
ts=lambda x:f"{int(x//3600):02}:{int(x%3600//60):02}:{int(x%60):02},{int(round((x%1)*1000)):03}"
open("narration.srt","w",encoding="utf-8").write("\n".join(f"{i}\n{ts(a)} --> {ts(b)}\n{t}\n" for i,(a,b,t) in enumerate(cues,1)))
inp=[];flt=[]
for i,(st,fn) in enumerate(place): inp+=["-i",fn]; flt.append(f"[{i}:a]adelay={int(st*1000)}:all=1[a{i}]")
flt.append("".join(f"[a{i}]" for i in range(len(place)))+f"amix=inputs={len(place)}:normalize=0,apad,atrim=0:{t0},loudnorm=I=-14:TP=-1[v]")
subprocess.run(["ffmpeg","-v","error","-y",*inp,"-filter_complex",";".join(flt),"-map","[v]","-ac","2","-ar","48000","narration_full.wav"],check=True)
json.dump(dict(total=t0,scenes=report),open("timing.json","w")); print("total",round(t0,1),report)
