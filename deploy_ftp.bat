@echo off
chcp 65001 >nul
title eOffice 2025 - FTP Deployment Tool
cd /d "%~dp0"
powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0deploy_ftp.ps1"
