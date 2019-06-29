setlocal
@ECHO OFF
title Aoto-Loop-PULL
set secs=60
echo.
echo ========================================
echo ==         自动更新Git代码，          ==
echo ==     每间隔%secs%秒种进行一次查询   ==
echo ========================================
echo.
cd..

:start
timeout %secs%
echo git pull

set "githome=C:\Program Files\Git\Bin"

set path=%githome%;%PATH%

cmd /c git pull
echo sleep
timeout %secs%
goto start
pause

