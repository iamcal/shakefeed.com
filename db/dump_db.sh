#!/bin/bash

DB_NAME="shakefeed"
DB_USER="shakefeed"

cd "$(dirname "$0")"

DB_PASS=`cat ../secrets/mysql_password`

for table in $(mysql -B -s -u${DB_USER} -p${DB_PASS} -D${DB_NAME} -e 'show tables')
do
  # dump each table in a separate file
  echo "dumping $table"
  $(mysqldump -u${DB_USER} -p${DB_PASS} --single-transaction --skip-dump-date --skip-extended-insert ${DB_NAME} ${table} > ./${table}.sql)
done
