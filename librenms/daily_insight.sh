#!/bin/bash
cp /opt/librenms/html/.htaccess_org /opt/librenms/html/.htaccess
/opt/librenms/daily.sh
cp /opt/librenms/html/.htaccess_insight /opt/librenms/html/.htaccess
