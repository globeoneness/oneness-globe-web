# Oneness Globe product videos: standing brief

Use this for every product video. Each product also has its own client prompt in `promo-video/<product>/PROMPT.md` (product facts, narration, dosage, tagline). If a product has no prompt yet, ask the client for one before writing narration.

## MANDATORY 3D & 4D PRODUCTION RULE (client, applies to every video; overrides older style notes)
- **Purpose:** a premium veterinary scientific documentary. It is educational, not a promotional advert.
- **Visuals:** exclusively photorealistic 3D anatomy and dynamic 4D (time-based) biological simulation:
  - photorealistic animals with natural movement, realistic skin, feathers and fur, and correct proportions
  - transparent anatomical cross-sections
  - camera moves from the outside of the animal into organs, tissues, cells and molecules
  - realistic blood flow, digestion, cell metabolism and molecular interactions
  - physically based rendering (PBR), volumetric light, depth of field, seamless transitions
  - continuous animation, never static images with zoom
- **Audio:**
  - a natural, mature Bangladeshi Bengali male voice that sounds like a veterinary specialist
  - accurate scientific pronunciation and natural pauses
  - no robotic or artificial voice, no artificial accent
  - no distracting background music
- **Bengali text:** never inside AI-generated footage. Add Unicode subtitles separately in Noto Sans Bengali, with proper complex-script shaping.
- **Output:** 1080×1920, 9:16, 30 fps, 120–180 s per product, MP4.
- **Never use:**
  - 2D animation, flat diagrams, cartoon animals, vector illustrations, slides or slideshows
  - distorted anatomy, artificial voices, broken Bengali characters
  - fabricated clinical results, unrealistic mechanisms, exaggerated claims

### What this means for production (feasibility)
- **This cloud environment cannot generate photorealistic 3D/4D footage.** There is no GPU, no AI video model, and no rigged and textured 3D animal or anatomy assets. Under this rule, the illustrated HTML/SVG pipeline in `one-immune/` must **not** be used for final videos.
- **Workflow under this rule:**
  1. Claude writes the Bengali narration and a shot-by-shot 3D/4D prompt list from the leaflet.
  2. The client generates the clips in an AI video tool (for example Google Veo, Runway, Kling or Sora) or a 3D studio, and records the voice with a human narrator. An Azure neural voice is an artificial voice and is not allowed under this rule.
  3. Claude assembles the final MP4: cuts the clips, syncs them to the voice, adds Noto Sans Bengali subtitles, does any light music or SFX work, and exports at 1080×1920.
- No paid tools or credits without the client's approval.

## Output
- **Length:** follows the narration with fast pacing (about 2:00). The client asked for faster pacing; 3:00 only if more scenes are added.
- **Voice settings:** Azure bn-BD-PradeepNeural, rate +6%, pitch -6%, volume +15%, broadcast EQ and compression (confident tone).
- **Music:** energetic, about 124 BPM, with drums and a drop at the pack reveal, ducked under the voice.
- **Resolution:** 1080p, 1080×1920, vertical 9:16, 30 fps, H.264 MP4 with AAC audio. Made for Facebook Reels, YouTube Shorts and mobile.
- **Deliver:**
  - the MP4
  - a few preview stills
  - `narration.srt` (Bengali voice-over cue sheet)
  - the editable source

## Voice-over is required
Do not render or deliver a video without a Bengali male voice-over. Narration audio comes first; the scenes are timed to it.

Voice: Bangladeshi Bengali, mature, confident, professional male. Ways to get it, in order of preference:
1. **Azure Speech free tier (F0)**, voice `bn-BD-PradeepNeural`.
   - Commercial use is allowed, and about 500k characters a month are free. One 3-minute video uses about 2k characters.
   - Needs the client's Azure Speech key and region. Ask for the key with the secure credential form, never in chat, and get network access approved for `<region>.tts.speech.microsoft.com`.
2. **Human narrator.** They record the lines in `narration.srt` as one audio file, and the video is fitted to that recording.
3. Microsoft Edge read-aloud (unofficial, no account). **Not recommended:** it is not licensed for commercial ads and may stop working.

If no voice source is available, stop and ask the client. Do not render a silent or subtitles-only video.
Do not use paid services or API credits without the client's approval.

## Language & text
- **Bengali:** natural Bangladeshi Bengali for all narration and subtitles.
- **Scientific terms:** shown in English alongside a Bengali explanation.
- **Voice-over:** mature, confident, professional male veterinary narrator. The client provides the recording, or adds a TTS voice if one becomes available.
  - Until then the video carries Bengali subtitles, and `narration.srt` gives the narrator exact timings.
  - `build.sh` mixes in `voiceover.wav` automatically when it is present.

## Story structure
1. Open with the animals' health or production problems (poultry and/or cattle on modern Bangladeshi farms).
2. Explain why this matters biologically, for example the gut barrier, immunity or the liver.
3. Reveal the original pack under premium lighting.
4. Formulation overview.
5. One scientific scene per key ingredient, showing only its established biological role.
6. Indications (poultry, then cattle), always worded as "supports" or "সহায়তা করে".
7. Treatment note: "not a substitute for vaccination or veterinary treatment", where relevant.
8. Dosage, copied exactly from the leaflet.
9. Tagline.
10. End screen:
    - the original ONENESS GLOBE logo and "Empowered by Unity"
    - www.onenessglobe.com
    - +8801339-562576
    - the disclaimer:
      > শুধুমাত্র প্রাণিচিকিৎসায় ব্যবহারের জন্য। রেজিস্টার্ড ভেটেরিনারি চিকিৎসকের পরামর্শ অনুযায়ী ব্যবহার করুন।

## Accuracy rules
- **Facts come only from the product leaflet.** The PDFs are ONE IMMUNE, Grow Pro, EssenGuard Plus, LivRen-G, Optiacid and Mycoclean Plus.
- **No invented mechanisms.** No clinical statistics, percentages, guaranteed cures or instant recovery.
- **Not a replacement for vaccines or medical treatment.**
- **Branding:** keep the original product name, logo, packaging, colours and branding. Use the real pack photo, cut out from the original image.
- **New narration needs approval.** Any narration lines Claude adds beyond the client's script are flagged for approval.

## Visual style
- Dark scientific look with cyan, teal and gold accents.
- Illustrated (vector) animals and farms, plus scientific diagrams: cells, microbes, molecules and organs.
- **Limitation:** photorealistic footage or 3D cannot be generated in this environment. Stock footage supplied by the client can be cut in.
- Music: original documentary-style score with subtle transition sound effects, generated by `music.py`, so it is royalty-free.

## Pipeline
`video.html` (scenes, HTML/SVG, deterministic `render(t)`) → `render.js` (Playwright frames) → `music.py` → ffmpeg. Run `./build.sh` (set `SCALE=2` for 4K).
