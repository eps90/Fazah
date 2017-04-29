#!/usr/bin/env bash
# Most of this script is copied from api-platform/api-platform project

COMPOSER_SIGNATURE=$(wget -q -O - https://composer.github.io/installer.sig)
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
INSTALLER_SIGNATURE=$(php -r "echo hash_file('SHA384', 'composer-setup.php');")

if [ "$COMPOSER_SIGNATURE" != "$INSTALLER_SIGNATURE" ]
then
    >&2 echo 'ERROR: Invalid installer signature'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quiet
RESULT=$?
rm composer-setup.php
exit $RESULT
