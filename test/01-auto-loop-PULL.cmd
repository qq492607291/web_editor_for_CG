setlocal
@ECHO OFF
title Aoto-Loop-PULL
set secs=60
echo.
echo ========================================
echo ==         �Զ�����Git���룬          ==
echo ==     ÿ���%secs%���ֽ���һ�β�ѯ   ==
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

