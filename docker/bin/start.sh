#!/bin/sh
set -e

# Populate "/data/upload/include/i18n" volume with language packs
if [ ! "$(ls -A /data/upload/include/i18n)" ]; then
      cp -r /data/upload/include/i18n.dist/* /data/upload/include/i18n
      chown -R www-data:www-data /data/upload/include/i18n
fi

# Automate installation
php /data/docker/bin/install.php

# Update database params for admin
SOPORTE_ADMIN_PASSWORD=${SOPORTE_ADMIN_PASSWORD:=Admin1}
SOPORTE_ADMIN_USERNAME=${SOPORTE_ADMIN_USERNAME:=ostadmin}
SOPORTE_ADMIN_FIRSTNAME=${SOPORTE_ADMIN_FIRSTNAME:=Admin}
SOPORTE_ADMIN_LASTNAME=${SOPORTE_ADMIN_LASTNAME:=User}
SOPORTE_EMAIL=${SOPORTE_EMAIL:=helpdesk@example.com}


mysql -u$SOPORTE_DATABASE_USER -p$SOPORTE_DATABASE_PASSWORD -h$SOPORTE_DATABASE_HOST << eof
  USE $SOPORTE_DATABASE_NAME;
  UPDATE soporte_staff SET username = "$SOPORTE_ADMIN_USERNAME", firstname = "$SOPORTE_ADMIN_FIRSTNAME", lastname = "$SOPORTE_ADMIN_LASTNAME", email = "$SOPORTE_ADMIN_EMAIL", passwd = md5("$SOPORTE_ADMIN_PASSWORD"), updated = NOW(), passwdreset = NOW() WHERE staff_id = 1;
  UPDATE soporte_staff SET username = "$SOPORTE_ADMIN_USERNAME", firstname = "$SOPORTE_ADMIN_FIRSTNAME", lastname = "$SOPORTE_ADMIN_LASTNAME", passwd = md5("$SOPORTE_ADMIN_PASSWORD"), updated = NOW(), passwdreset = NOW() WHERE staff_id = 1;
  UPDATE soporte_email SET email = "$SOPORTE_EMAIL", updated = NOW() WHERE email_id = 1;
  UPDATE soporte_config SET value = "$SOPORTE_ADMIN_EMAIL", updated = NOW() WHERE id = 1 LIMIT 1;
  UPDATE soporte_form_entry_values SET value = "$SOPORTE_NAME" WHERE (entry_id = 2 AND field_id = 23) LIMIT 1;
eof
#End update database

echo Applying configuration file security
chmod 644 /data/upload/include/ost-config.php

mkdir -p /run/nginx
chown -R www-data:www-data /run/nginx
chown -R www-data:www-data /var/lib/nginx
mkdir -p /var/log/php
chown -R www-data:www-data /var/log/php

#Launch supervisor to manage processes
exec /usr/bin/supervisord -c /data/docker/conf/supervisord.conf
