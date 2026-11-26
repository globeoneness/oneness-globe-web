# Generates the Bengali voice-over with Azure Speech (bn-BD-PradeepNeural) and the scene timing.
# Outputs: vo/*.mp3 clips, voiceover.wav (full track), vo_timing.js (read by video.html).
# The Azure key is injected by the environment's network proxy; this script never handles it.
import json, subprocess, os, html
REGION = "centralindia"; VOICE = "bn-BD-PradeepNeural"; RATE = "-8%"; TOTAL = 180.0; FPS = 30
# (scene id, original visual seconds, [(subtitle text, text sent to TTS or None = same)])
PLAN = [
 ("A", 3.5, []),
 ("B", 6, [("রোগ প্রতিরোধক্ষমতা দুর্বল হলে প্রাণীর সংক্রমণের ঝুঁকি বাড়তে পারে।", None)]),
 ("C", 6, [("পরিবেশগত ধকল, অপুষ্টি ও অসুস্থতার প্রভাবে কমে যেতে পারে খামারের উৎপাদনশীলতা।", None)]),
 ("D", 10, [("প্রাণীর শরীরে জন্মগত ও অর্জিত রোগ প্রতিরোধব্যবস্থা বিভিন্ন জীবাণুর বিরুদ্ধে কাজ করে।", None),
            ("এই প্রতিরক্ষা ব্যবস্থার স্বাভাবিক কার্যক্রমের জন্য প্রয়োজন যথাযথ পুষ্টি ও সুস্থ অন্ত্র।", None)]),
 ("E", 7.5, [("প্রাণীর রোগ প্রতিরোধব্যবস্থাকে পুষ্টিগত সহায়তা দিতে Oneness Globe-এর ONE IMMUNE।",
             "প্রাণীর রোগ প্রতিরোধব্যবস্থাকে পুষ্টিগত সহায়তা দিতে, ওয়াননেস গ্লোব-এর, ওয়ান ইমিউন।")]),
 ("F", 8.5, [("প্রোবায়োটিক, প্রিবায়োটিক, এনজাইম, লাইসোজাইম, ভিটামিন ও অ্যান্টিঅক্সিডেন্টের সমন্বয়ে তৈরি", None),
             ("একটি আধুনিক সিনবায়োটিক ইমিউন এনহ্যান্সার।", None)]),
 ("G", 6.5, [("লাইসোজাইম ও বিটা-গ্লুকান শরীরের প্রাকৃতিক প্রতিরক্ষা ব্যবস্থাকে সহায়তা করে।", None)]),
 ("H", 6, []),
 ("I", 7.5, [("প্রোবায়োটিক ও প্রিবায়োটিক অন্ত্রের মাইক্রোফ্লোরার ভারসাম্য বজায় রাখতে,", None)]),
 ("J", 6, []),
 ("K", 6.5, [("এবং ভিটামিন ও অ্যান্টিঅক্সিডেন্ট অক্সিডেটিভ স্ট্রেস মোকাবিলায় ভূমিকা রাখে।", None)]),
 ("L", 7.5, [("পোল্ট্রিতে রোগ প্রতিরোধক্ষমতা, হজম, পুষ্টি শোষণ, FCR, ডিম উৎপাদন", "পোল্ট্রিতে রোগ প্রতিরোধক্ষমতা, হজম, পুষ্টি শোষণ, এফ সি আর, ডিম উৎপাদন"),
             ("এবং সংক্রমণকালীন পুনরুদ্ধারে সহায়ক ONE IMMUNE।", "এবং সংক্রমণকালীন পুনরুদ্ধারে সহায়ক, ওয়ান ইমিউন।")]),
 ("M", 6.5, [("গবাদিপশুর রুমেনের মাইক্রোবিয়াল ভারসাম্য, খাদ্যের কার্যকর ব্যবহার, বিপাকীয় স্বাস্থ্য,", None)]),
 ("N", 6.5, [("দুধ উৎপাদন এবং প্রজননক্ষমতা বজায় রাখতেও সহায়তা করে ONE IMMUNE।", "দুধ উৎপাদন এবং প্রজননক্ষমতা বজায় রাখতেও সহায়তা করে, ওয়ান ইমিউন।")]),
 ("O", 6, [("ম্যাস্টাইটিস ও অন্যান্য ধকলজনিত অবস্থায় চিকিৎসার পাশাপাশি পুনরুদ্ধারে পুষ্টিগত সহায়তা দিতে পারে।", None)]),
 ("P", 6.5, [("পোল্ট্রি: প্রতি ২–৩ লিটার পানিতে ১ গ্রাম।", "পোল্ট্রি: প্রতি দুই থেকে তিন লিটার পানিতে এক গ্রাম।"),
             ("গবাদিপশু: প্রতি ১০–২০ কেজি দৈহিক ওজনের জন্য ১ গ্রাম, পানির মাধ্যমে।", "গবাদিপশু: প্রতি দশ থেকে বিশ কেজি দৈহিক ওজনের জন্য এক গ্রাম, পানির মাধ্যমে।")]),
 ("Q", 4.5, [("ভেতর থেকে প্রতিরক্ষার পুষ্টিগত সহায়তা — ONE IMMUNE।", "ভেতর থেকে প্রতিরক্ষার পুষ্টিগত সহায়তা, ওয়ান ইমিউন।")]),
 ("R", 7, [("শুধুমাত্র প্রাণিচিকিৎসায় ব্যবহারের জন্য। রেজিস্টার্ড ভেটেরিনারি চিকিৎসকের পরামর্শ অনুযায়ী ব্যবহার করুন।", None)]),
]
LEAD, GAP, TAIL = 0.7, 0.45, 0.9
os.makedirs("vo", exist_ok=True)
def tts(text, fn):
    if os.path.exists(fn) and os.path.getsize(fn) > 1000: return
    ssml = f'<speak version="1.0" xml:lang="bn-BD"><voice name="{VOICE}"><prosody rate="{RATE}">{html.escape(text)}</prosody></voice></speak>'
    r = subprocess.run(["curl","-s","-o",fn,"-w","%{http_code}","-X","POST",f"https://{REGION}.tts.speech.microsoft.com/cognitiveservices/v1",
        "-H","Content-Type: application/ssml+xml","-H","X-Microsoft-OutputFormat: audio-48khz-192kbitrate-mono-mp3","-H","User-Agent: promo-video",
        "--data-binary",ssml.encode()],capture_output=True,text=True)
    assert r.stdout=="200", f"TTS failed {r.stdout} for {text}"
def dur(fn): return float(subprocess.check_output(["ffprobe","-v","error","-show_entries","format=duration","-of","csv=p=0",fn]))
scenes=[]
for sid,d,lines in PLAN:
    clips=[]
    for k,(sub,say) in enumerate(lines):
        fn=f"vo/{sid}{k}.mp3"; tts(say or sub, fn); clips.append((sub,fn,dur(fn)))
    need = LEAD + sum(c[2] for c in clips) + GAP*max(0,len(clips)-1) + TAIL if clips else 0
    scenes.append(dict(id=sid,orig=d,need=need,clips=clips))
# scene length: max(visual minimum, voice need); then spread remaining time to reach TOTAL
base=[max(s["orig"],s["need"]) for s in scenes]; extra=TOTAL-sum(base); assert extra>=0, f"voice too long: {sum(base)}"
w=sum(s["orig"] for s in scenes)
for s,b in zip(scenes,base): s["d"]=round((b+extra*s["orig"]/w)*FPS)/FPS
scenes[-1]["d"]+=TOTAL-sum(s["d"] for s in scenes)
out={}; t=0; parts=[]
for s in scenes:
    subs=[]; pad=(s["d"]-s["need"])/2 if s["clips"] else 0; x=LEAD+max(0,pad*0.6)
    for sub,fn,dd in s["clips"]:
        subs.append([round(x,2),round(x+dd+0.15,2),sub]); parts.append((t+x,fn)); x+=dd+GAP
    out[s["id"]]=dict(d=s["d"],subs=subs); t+=s["d"]
open("vo_timing.js","w",encoding="utf-8").write("window.VOT="+json.dumps(out,ensure_ascii=False)+";")
# assemble full voice track
inputs=[];flt=[]
for i,(st,fn) in enumerate(parts): inputs+=["-i",fn]; flt.append(f"[{i}:a]adelay={int(st*1000)}:all=1,aresample=48000[a{i}]")
flt.append("".join(f"[a{i}]" for i in range(len(parts)))+f"amix=inputs={len(parts)}:normalize=0,apad,atrim=0:{TOTAL},loudnorm=I=-16:TP=-1.5[v]")
subprocess.run(["ffmpeg","-v","error","-y",*inputs,"-filter_complex",";".join(flt),"-map","[v]","-ac","2","voiceover.wav"],check=True)
print("total",round(t,2),"speech",round(sum(c[2] for s in scenes for c in s["clips"]),1))
for s in scenes: print(s["id"],round(s["d"],2),"voice",round(s["need"],1))
