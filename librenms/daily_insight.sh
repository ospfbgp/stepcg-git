#!/bin/bash
cp /opt/librenms/html/.htaccess.org /opt/librenms/html/.htaccess 
/opt/librenms/daily.sh
cp /opt/librenms/html/.htaccess.insight /opt/librenms/html/.htaccess 
