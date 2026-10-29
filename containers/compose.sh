#!/bin/sh
set -eu
cd "$(dirname "$0")/.."
export PODMAN_COMPOSE_PROVIDER="${PODMAN_COMPOSE_PROVIDER:-podman-compose}"
exec podman compose --env-file "${RELEASE_ENV_FILE:-.env.release}" "$@"
