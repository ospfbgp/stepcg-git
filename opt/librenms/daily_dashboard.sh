#!/bin/bash
echo "cp /opt/librenms/html/.htaccess_org /opt/librenms/html/.htaccess"
cp /opt/librenms/html/.htaccess_org /opt/librenms/html/.htaccess 
sleep 2
/opt/librenms/daily.sh
echo "/opt/librenms/html/.htaccess_dashboard /opt/librenms/html/.htaccess"
cp /opt/librenms/html/.htaccess_dashboard /opt/librenms/html/.htaccess
