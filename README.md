Webinterface of the WPN-XM Server Stack. [![Build Status](https://travis-ci.org/WPN-XM/webinterface.png)](https://travis-ci.org/WPN-XM/webinterface)

FIXES
====
- paths for images  (was not working when the server wasnt on port 80)
- start & stop daemons
- open notepad (log, error) via ajax call to avoid page refresh

TEST
====
execute:
C:\server\bin\php\php -S localhost:90 -t C:\server\www

Navigate to:
localhost:90

goto "Overview", Test "start/stop" nginx, and "start/stop" php-cgi

