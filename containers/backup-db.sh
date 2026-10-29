#!/usr/bin/env bash
# Variables in the quoted commands belong to the database container.
# shellcheck disable=SC2016
set -euo pipefail
umask 077
compose="$(cd "$(dirname "$0")" && pwd)/compose.sh"
output="${1:?Usage: containers/backup-db.sh /secure/path/database.sql.gz}"
temporary="${output}.partial"
if [[ -e "$output" || -e "$temporary" ]]; then
    echo 'Backup destination already exists; choose a new filename.' >&2
    exit 1
fi
trap 'rm -f -- "$temporary"' EXIT
"$compose" exec -T database sh -ec '
    export MYSQL_PWD="$MYSQL_ROOT_PASSWORD"
    exec mysqldump -uroot --single-transaction --routines --events --triggers --no-tablespaces --set-gtid-purged=OFF --column-statistics=0 "$MYSQL_DATABASE"
' | gzip > "$temporary"
gzip -t "$temporary"
mv -- "$temporary" "$output"
echo "Database backup written to $output"
