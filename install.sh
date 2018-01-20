#!/bin/bash
ln -s /var/www/html/shakefeed.com/site.conf /etc/apache2/sites-available/shakefeed.com.conf
chown root:root /var/www/html/shakefeed.com/crontab
chmod g-w /var/www/html/shakefeed.com/crontab
ln -s /var/www/html/shakefeed.com/crontab /etc/cron.d/shakefeed
a2ensite shakefeed.com
service apache2 reload
cd /var/www/html/shakefeed.com/db
./init_db.sh
