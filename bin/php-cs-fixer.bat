@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/fabpot/php-cs-fixer/php-cs-fixer
php "%BIN_TARGET%" %*
