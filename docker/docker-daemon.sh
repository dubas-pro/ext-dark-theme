#!/usr/bin/env bash

if [ -f /var/www/default/site/daemon.php ]; then
    /usr/local/bin/php /var/www/default/site/daemon.php
fi
