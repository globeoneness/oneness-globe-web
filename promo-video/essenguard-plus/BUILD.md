# EssenGuard Plus 3D build (free, local)
1. `npm install three@0.160.0` in this folder; `python3 -m http.server 8765 --bind 127.0.0.1 &`
2. Narration: `python3 eg_voice.py` (Azure Free F0 bold voice) -> narration_full.wav, narration.srt, timing.json; then regenerate data.js (subs + scene times).
3. Frames: `for w in 0 1 2 3; do node render3d.js frames $w 4 & done; wait`  (WebGL via SwiftShader, ~35 min on 4 CPUs)
4. Music: `python3 music.py`; mix with narration (music at 0.28, sidechain-ducked), then ffmpeg encode 1080x1920 30 fps.
Molecules use real 3D coordinates generated with RDKit (MMFF-optimised) in molecules.js.
