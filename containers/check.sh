#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
frontend_source="${1:-../bulsca-frontend}"
hadolint="${HADOLINT_BIN:-${TMPDIR:-/tmp}/bulsca-hadolint-2.15.1}"
if [[ ! -x "$hadolint" ]]; then
    curl -fsSL https://github.com/hadolint/hadolint/releases/download/v2.15.1/hadolint-linux-x86_64 -o "$hadolint"
fi
printf '%s  %s\n' c7187db94eeeeca956519a6af171adc31453941a1e777961f6e680f697c8c507 "$hadolint" | sha256sum -c -
chmod +x "$hadolint"
"$hadolint" Containerfile "$frontend_source/Containerfile"
"${SHELLCHECK_BIN:-shellcheck}" containers/*.sh containers/*.envsh "$frontend_source/containers/10-resolvers.envsh"
python3 tools/check_compose.py
python3 tools/verify_container_routing.py --frontend "$frontend_source" --nginx "${NGINX_BIN:-$(command -v nginx)}" --fastcgi-params "${FASTCGI_PARAMS:-/etc/nginx/fastcgi_params}"
node --test tools/smoke_release.test.mjs
