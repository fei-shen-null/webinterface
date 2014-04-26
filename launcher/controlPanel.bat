@echo off

:: ***********************************************************
:: THIS FILE SHOULD BE PLACED AND RUN FROM C:\Server\bin\tools
:: ***********************************************************

:: kill, if it is running
process -k php.exe

:: start PHP in server mode and serve the ww folder with webinterface
start "localhost:90-WPN-XM Server Stack" /MIN ../php/php -S localhost:90 -t ../../www

:: start WPN-XM Server Control Panel
start http://localhost:90/tools/webinterface
