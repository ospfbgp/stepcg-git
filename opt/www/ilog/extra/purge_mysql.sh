#!/bin/bash
# This will remove all records older than 7 days
# needs to run in cron daily
# create file /etc/cron.d/ilog and add the following lines
# purge ilog tables
# 16   0    * * *   root   /opt/www/ilog/extra/purge_mysql.sh  >> /dev/null 2>&1
SQL_syslog="DELETE FROM syslog WHERE datetime < NOW() - INTERVAL 7 DAY"
SQL_syslog="DELETE FROM syslog WHERE seq NOT IN ( SELECT seq FROM ( SELECT seq FROM syslog ORDER BY seq DESC LIMIT 250000 ) ilog);"

SQL_ignition_catId_10="DELETE FROM ignition_catId_10 WHERE datetime < NOW() - INTERVAL 7 DAY"
SQL_ignition_catId_10="DELETE FROM ignition_catId_10 WHERE seq NOT IN ( SELECT seq FROM ( SELECT seq FROM ignition_catId_10 ORDER BY seq DESC LIMIT 250000 ) ilog);"

SQL_nac="DELETE FROM nac WHERE datetime < NOW() - INTERVAL 7 DAY"
SQL_nac="DELETE FROM nac WHERE seq NOT IN ( SELECT seq FROM ( SELECT seq FROM ignition_catId_10 ORDER BY seq DESC LIMIT 250000 ) ilog);"

MYSQL_USER="ilog"
MYSQL_PASS="ilogpassword"
MYSQL_DB="ilog"

echo $SQL_syslog | /usr/bin/mysql --user=$MYSQL_USER --password=$MYSQL_PASS $MYSQL_DB
echo $SQL_ignition_catId_10 | /usr/bin/mysql --user=$MYSQL_USER --password=$MYSQL_PASS $MYSQL_DB
echo $SQL_nac | /usr/bin/mysql --user=$MYSQL_USER --password=$MYSQL_PASS $MYSQL_DB
