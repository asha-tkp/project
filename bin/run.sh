
rm -rf /var/www/html/var/cache/dev/*
rm -rf /var/www/html/var/logs/dev/*

composer install

/var/www/html/bin/console cache:clear
/var/www/html/bin/console cache:warmup
/var/www/html/bin/console fos:js-routing:dump
/var/www/html/bin/console assets:install
/var/www/html/bin/console assetic:dump

mkdir -p  /var/www/html/var/sessions/dev
chmod -R 777 /var/www/html/var/*
