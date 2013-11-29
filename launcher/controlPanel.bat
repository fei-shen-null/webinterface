REM ***********************************************************
REM THIS FILE SHOULD BE PLACED AND RUN FROM C:\Server\bin\tools
REM ***********************************************************

rem Kill if it is running
process -k php.exe

rem start php dev server
start "localhost:90-WPN-XM Dev Server" /MIN ../php/php -S localhost:90 -t ../../www

rem start WPN-XM Server Control Panel
start http://localhost:90/webinterface
