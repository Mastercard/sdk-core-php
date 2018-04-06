#!/bin/bash

CURRENT_DIR=${PWD}
PHP=$(whereis php)

echo "Running test using phpunit."
$PHP $CURRENT_DIR/vendor/bin/phpunit
