# alert_vX.sql
# mysqldump librenms alert_templates alert_rules alert_template_map > alert_v2.sql  

sudo bash
rm -fr /home/stepcg/stepcg-git
git clone https://github.com/ospfbgp/stepcg-git /home/stepcg/stepcg-git
mysql --user=root librenms < ~/stepcg-git/scripts/mysql/alert_v2.sql
