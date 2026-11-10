@echo off
title National Youth Development Platform - Laravel Server
set PATH=C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64;C:\laragon\bin\composer;%PATH%
echo ========================================================
echo  National Youth Development Platform - Laravel 11/13
echo  Starting local server on http://127.0.0.1:8000
echo ========================================================
echo.
php artisan serve --port=8000
pause
