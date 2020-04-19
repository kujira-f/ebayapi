@echo off

chcp 65001
set time2=%time: =0%
C:\xampp\php\php.exe c:\ebayapi\ebayapi_get.php > c:\ebayapi\log\log%DATE:~-10,4%%DATE:~-5,2%%DATE:~-2%%time2:~0,2%%time2:~3,2%%time2:~6,2%.txt
