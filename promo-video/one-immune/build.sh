#!/usr/bin/env bash
# Full build: frames (4K) -> MP4 with music (+ optional voice-over).
# Requirements: node + playwright (chromium), python3 + numpy + scipy, ffmpeg.
# Optional: put a recorded Bengali voice-over at voiceover.wav (timed to narration.srt) and it will be mixed in.
set -e; cd "$(dirname "$0")"
node render.js preview                       # writes timeline.json + preview stills
python3 music.py && ffmpeg -v error -y -i music.wav -af loudnorm=I=-18:TP=-1.5:LRA=11 -ar 48000 music_norm.wav
python3 make_srt.py
W=${WORKERS:-4}; for w in $(seq 0 $((W-1))); do node render.js frames $w $W ${SCALE:-1} & done; wait
AUDIO=music_norm.wav
if [ -f voiceover.wav ]; then   # duck music under the voice
  ffmpeg -v error -y -i music_norm.wav -i voiceover.wav -filter_complex \
   "[0:a]volume=0.55[m];[1:a]aresample=48000,loudnorm=I=-16:TP=-1.5[v];[m][v]sidechaincompress=threshold=0.05:ratio=6:attack=20:release=400[d];[d][v]amix=inputs=2:normalize=0[a]" \
   -map "[a]" mix.wav; AUDIO=mix.wav; fi
ffmpeg -y -framerate 30 -i frames/f%05d.jpg -i $AUDIO -c:v libx264 -preset slow -crf 16 -profile:v high -level 4.2 \
  -pix_fmt yuv420p -colorspace bt709 -color_primaries bt709 -color_trc bt709 -c:a aac -b:a 256k -shortest -movflags +faststart ONE_IMMUNE_1080p.mp4
ffmpeg -y -i ONE_IMMUNE_1080p.mp4 -vf scale=720:1280 -c:v libx264 -crf 24 -preset medium -c:a aac -b:a 128k -movflags +faststart ONE_IMMUNE_preview_720p.mp4
