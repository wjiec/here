#!/usr/bin/env bash
set -eo pipefail

# switch user postgres
if [[ "${1}" == 'postgres' && "$(id -u)" == '0' ]]; then
    chown postgres:postgres "${PGSQL_DATA_PATH}"
    exec su-exec postgres "$BASH_SOURCE" "$@"
fi

if [[ "${1}" == 'postgres' ]]; then
    # initializing database server
    if [[ ! -s "${PGSQL_DATA_PATH}/PG_VERSION" ]]; then
        initdb --username="postgres" --pwfile=<(echo "${POSTGRES_PASSWORD}")

        AUTH_METHOD=trust
        if [[ -n "${POSTGRES_PASSWORD}" ]]; then
            AUTH_METHOD=md5
        fi

        {
            echo;
            echo "host all all all ${AUTH_METHOD}"
        } >> "${PGSQL_DATA_PATH}/pg_hba.conf"

        pg_ctl -D "${PGSQL_DATA_PATH}" -o "-c listen_addresses=''" -w start
        psql=( psql -h "${PGSQL_RUN_PATH}" -v ON_ERROR_STOP=1 --username "postgres" --no-password )
        for filename in /var/pgsql/initdb.d/*; do
            echo;
            case "${filename}" in
                *.sh)
                    if [[ -x "${filename}" ]]; then
                        echo "$0: running ${filename}"
						"${filename}"
                    fi
                ;;
                *.sql)
                    echo "$0: running ${filename}";
                    "${psql[@]}" -f "${filename}";
                    echo;
                ;;
                *)
                    echo "$0: ignoring ${filename}"
                ;;
            esac
            echo;
        done
        pg_ctl -D "${PGSQL_DATA_PATH}" -m fast -w stop

        echo
		echo 'PostgreSQL init process complete; ready for start up.'
		echo
    fi
fi

exec "$@"
