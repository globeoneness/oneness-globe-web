# ONE IMMUNE: promotional video source

Vertical 9:16, 1080×1920 (1080p), 30 fps, 3:00. Bengali subtitles, documentary-style music and transition sound effects.

## Files
| File | What it is |
|---|---|
| `video.html` | All scenes, animation and on-screen text. Each scene is one `S("id", seconds, build, update, subtitles)` block. Change text, timing or colours here. |
| `render.js` | Playwright frame renderer. `node render.js preview` saves stills and `timeline.json`; `node render.js frames <worker> <workers> 2` renders frames (last arg = scale: 1 = 1080p, 2 = 4K). |
| `music.py` | Generates the score and sound effects in sync with `timeline.json`. No samples, no licences needed. |
| `make_srt.py` → `narration.srt` | Bengali voice-over cue sheet with exact timings. |
| `build.sh` | One command rebuild: frames → MP4 (+ voice-over mix if `voiceover.wav` exists). |
| `pack.png`, `logo.png`, `fonts/` | Pack cut-out from the original product photo, company logo, Hind Siliguri font (SIL Open Font License). |

## Scenes
A intro · B poultry challenges · C cattle challenges · D gut barrier & dysbiosis · E pack reveal · F formulation · G lysozyme · H β-glucans · I probiotics/prebiotics/MOS · J xylanase + protease · K Vitamin E, C, selenium · L poultry indications · M rumen fermentation · N cattle indications · O treatment support (not a vaccine/treatment substitute) · P dosage · Q tagline · R end screen + disclaimer.

## Adding the Bengali voice-over
1. Have a narrator record each line in `narration.srt` within its time window (one continuous WAV, starting at 0:00).
2. Save it as `voiceover.wav` in this folder and run `./build.sh`. Music is ducked automatically under the voice.

Narration lines for scenes G–K (lysozyme, β-glucan, probiotics, enzymes, antioxidants) were **added** by Claude to cover the science scenes. They are based on the product leaflet and should be approved before recording. All other lines are the client's own text.
