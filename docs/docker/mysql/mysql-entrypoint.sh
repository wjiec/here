#!/usr/bin/env sh
set -eo pipefail


if [[ "$@" == "mysql-daemon" ]]; then
    if [[ -z "${MYSQL_ROOT_PASSWORD}" ]]; then
        echo >&2 'error: database is uninitialized and password option is not specified '
        echo >&2 '  You need to specify MYSQL_ROOT_PASSWORD'
        exit 1
    fi

    DATA_DIR=`mysqld --verbose --help | grep 'datadir' 2>/dev/null | awk '$1 == "datadir" {print $2; exit}'`

    if [[ ! -d "${DATA_DIR}" -o "$(ls ${DATA_DIR} | wc -l)" == 0 ]]; then
        mkdir -p "${DATA_DIR}"

        echo 'Initializing database'
        mysqld_safe --initialize-insecure --user=mysql
        echo 'Database initialized'

        echo 'Initializing certificates'
        mysql_ssl_rsa_setup --datadir="${DATA_DIR}"
        echo 'Certificates initialized'

        SOCKET=`mysqld --verbose --help | grep 'socket' 2>/dev/null | awk '$1 == "socket" {print $2; exit}'`
        mysqld_safe --skip-networking --socket="${SOCKET}" &

        for i in $(seq 0 8); do
            if echo 'select 1' | mysql --protocol=socket -uroot -hlocalhost --socket="${SOCKET}" &>/dev/null; then
                break
            fi

            echo 'MySQL init process in progress...'
            sleep 1
        done

        mysql --protocol=socket -uroot -hlocalhost --socket="${SOCKET}" <<-EOF
            SET @@SESSION.SQL_LOG_BIN=0;
            SET PASSWORD FOR 'root'@'localhost'=PASSWORD('${MYSQL_ROOT_PASSWORD}');
            GRANT ALL ON *.* TO 'root'@'localhost' WITH GRANT OPTION;
            CREATE USER 'root'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}';
            GRANT ALL ON *.* TO 'root'@'%' WITH GRANT OPTION;
            DROP DATABASE IF EXISTS test;
            FLUSH PRIVILEGES;
EOF

        PID=`ps -ef | grep 'mysqld' | grep -v 'grep' | awk '{print $1}'`
        echo "${PID}" | xargs kill -9

        sleep 3

        echo 'MySQL init process done. Ready for start up.'
        exec mysqld --user=mysql
    else
        SOCKET=`mysqld --verbose --help | grep 'socket' 2>/dev/null | awk '$1 == "socket" {print $2; exit}'`
        exec mysqld --user=mysql
    fi
else
    exec "$@"
fi
