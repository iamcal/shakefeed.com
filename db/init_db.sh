#!/bin/bash

DB_NAME="shakefeed"
DB_USER="shakefeed"

cd "$(dirname "$0")"

# get mysql root password
ROOT_PASS=`cat /root/mysql_root`

# generate a new user password
DB_PASS=`< /dev/urandom tr -dc A-Za-z0-9 | head -c${1:-32};echo;`
echo $DB_PASS > ../secrets/mysql_password
echo "New password for ${DB_USER} is ${DB_PASS} - no need to write this down"

# create the DB
$(mysql -uroot -p${ROOT_PASS} -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\`")

# create the user
$(mysql -uroot -p${ROOT_PASS} -e "GRANT ALL ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';")

# import schema
./import_db.sh
