#!/usr/bin/env bash
# Builds the two installable theme packages into wordpress/dist/.
#   full: everything, including the six original PDFs (about 7.5 MB)
#   lite: no PDFs, 1800 px brochure images (about 2 MB) — PDFs are uploaded to the Media Library instead
set -euo pipefail
cd "$(dirname "$0")/.."
VER=$(grep -m1 '^Version:' oneness-globe/style.css | awk '{print $2}')
LIT_SRC=${LIT_SRC:-/home/user/scratchpad_wp/lit}   # 300 dpi PNG renders of the PDFs
mkdir -p dist
rm -f dist/oneness-globe-wordpress-theme-v*.zip dist/oneness-globe-theme-v*-lite.zip
zip -qr -X "dist/oneness-globe-wordpress-theme-v${VER}.zip" oneness-globe
B=$(mktemp -d); cp -r oneness-globe "$B/"; rm -rf "$B/oneness-globe/assets/pdf"
python3 - "$LIT_SRC" "$B/oneness-globe/assets/literature" <<'PY'
import sys
from PIL import Image
src, dst = sys.argv[1], sys.argv[2]
for s in ['one-immune','grow-pro','essenguard-plus','livren-g','optiacid','mycoclean-plus']:
    im = Image.open(f'{src}/{s}.png').convert('RGB')
    im = im.resize((1800, round(im.size[1] * 1800 / im.size[0])), Image.LANCZOS)
    im.save(f'{dst}/{s}.webp', 'WEBP', quality=80, method=6)
PY
(cd "$B" && zip -qr -X "$OLDPWD/dist/oneness-globe-theme-v${VER}-lite.zip" oneness-globe)
rm -rf "$B"
ls -la dist
