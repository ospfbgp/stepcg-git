# alert_templates_v1.sql:  This mysql table alert_templates is a table inside Librenms.  It has been formated for email and slack.  
# You will need to pin your alert rules to the alert templates after importing into your librenms database

rm -fr /home/stepcg/stepcg-git
git clone https://github.com/ospfbgp/stepcg-git /home/stepcg/stepcg-git
mysql --user=root -p librenms < ~/stepcg-git/scripts/mysql/alert_templates_v2.sql
mysql --user=root -p librenms < ~/stepcg-git/scripts/mysql/alert_rules_v2.sql
