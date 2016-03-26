@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/fabpot/php-cs-fixer/php-cs-fixer
php "%BIN_TARGET%" %*
