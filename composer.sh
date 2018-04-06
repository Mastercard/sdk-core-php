#!/bin/bash

CURRENT_DIR=${PWD}
PHP=$(whereis php)

echo "Updating composer binary."
$PHP $CURRENT_DIR/bin/composer.phar self-update
echo "php $CURRENT_DIR/bin/composer.phar $@"
$PHP "$CURRENT_DIR/bin/composer.phar" "$@"
