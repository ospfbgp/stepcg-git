# alert_templates_v1.sql:  This mysql table alert_templates is a table inside Librenms.  It has been formated for email and slack.  
# You will need to pin your alert rules to the alert templates after importing into your librenms database

mysql --user=root -p librenms < alert_templates_v1.sql
