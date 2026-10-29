#!/usr/bin/env bash
# Variables in the quoted commands belong to the database container.
# shellcheck disable=SC2016
set -euo pipefail
compose="$(cd "$(dirname "$0")" && pwd)/compose.sh"
input="${1:?Usage: containers/restore-db.sh backup.sql.gz --confirm-empty-database}"
if [[ "${2:-}" != --confirm-empty-database ]]; then
    echo 'Restore requires --confirm-empty-database and a fresh database volume.' >&2
    exit 1
fi
gzip -t "$input"
"$compose" exec -T database sh -ec '
    export MYSQL_PWD="$MYSQL_ROOT_PASSWORD"
    count=$(mysql -uroot -D"$MYSQL_DATABASE" -Nse "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema=DATABASE()")
    test "$count" = 0 || { echo "Restore refused: target database is not empty." >&2; exit 1; }
'
# Start only the database during restoration; application writers must be stopped.
gzip -dc "$input" | "$compose" exec -T database sh -ec '
    export MYSQL_PWD="$MYSQL_ROOT_PASSWORD"
    exec mysql -uroot --binary-mode=1 --default-character-set=utf8mb4 "$MYSQL_DATABASE"
'
echo 'Restore completed. Check import output, row counts, migrations and files before starting application writers.'
