# ==============================================================================
# eOffice 2025 - Automated FTP Deployment Tool (PowerShell)
# ==============================================================================
[Console]::OutputEncoding = [System.Text.Encoding]::UTF8
$OutputEncoding = [System.Text.Encoding]::UTF8

$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
Set-Location $scriptDir

$configFile = Join-Path $scriptDir "ftp_config.json"
$exampleConfigFile = Join-Path $scriptDir "ftp_config.example.json"

function Write-Header {
    Clear-Host
    Write-Host "==========================================================" -ForegroundColor Cyan
    Write-Host "   ระบบอัปโหลดไฟล์ขึ้น Hosting ผ่าน FTP (eOffice 2025)   " -ForegroundColor Yellow -NoNewline
    Write-Host ""
    Write-Host "==========================================================" -ForegroundColor Cyan
}

# 1. ตรวจสอบไฟล์การตั้งค่า
if (-not (Test-Path $configFile)) {
    Write-Header
    Write-Host "[!] ยังไม่พบไฟล์การตั้งค่า: ftp_config.json" -ForegroundColor Yellow
    Write-Host "กรุณากรอกข้อมูลการเชื่อมต่อ FTP สำหรับ Hosting ของคุณ:" -ForegroundColor White
    Write-Host ""

    $hostInput = Read-Host "1. FTP Host / IP (เช่น ftp.phatthalung.go.th หรือ IP)"
    $userInput = Read-Host "2. FTP Username"
    $passInput = Read-Host "3. FTP Password" -AsSecureString
    $BSTR = [System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($passInput)
    $plainPass = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)

    $rootInput = Read-Host "4. Remote Root Path บนโฮสต์ (ค่าเริ่มต้น /public_html กด Enter ได้เลย)"
    if ([string]::IsNullOrWhiteSpace($rootInput)) {
        $rootInput = "/public_html"
    }

    $configObj = @{
        host = $hostInput.Trim()
        port = 21
        username = $userInput.Trim()
        password = $plainPass
        remote_root = $rootInput.Trim()
        use_ssl = $false
        passive_mode = $true
    }

    $configJson = $configObj | ConvertTo-Json -Depth 4
    [System.IO.File]::WriteAllText($configFile, $configJson, [System.Text.Encoding]::UTF8)
    Write-Host ""
    Write-Host "[✓] บันทึกการตั้งค่าลง ftp_config.json เรียบร้อยแล้ว (ไฟล์นี้จะไม่ถูกอัปขึ้น Git)" -ForegroundColor Green
    Start-Sleep -Seconds 1
}

# 2. โหลด Config
$config = Get-Content $configFile -Raw -Encoding UTF8 | ConvertFrom-Json

# Helper: สร้าง Directory ฝั่ง Remote FTP ถ้ายังไม่มี
function Ensure-FtpDirectory {
    param (
        [string]$remoteDirPath,
        [PSCustomObject]$cfg
    )

    $parts = $remoteDirPath.Trim('/').Split('/')
    $currentPath = ""

    foreach ($part in $parts) {
        if ([string]::IsNullOrWhiteSpace($part)) { continue }
        $currentPath += "/" + $part
        $dirUri = "ftp://$($cfg.host):$($cfg.port)$currentPath"

        try {
            $req = [System.Net.FtpWebRequest]::Create($dirUri)
            $req.Credentials = New-Object System.Net.NetworkCredential($cfg.username, $cfg.password)
            $req.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
            $req.UsePassive = $cfg.passive_mode
            $req.EnableSsl = $cfg.use_ssl
            $req.Timeout = 5000
            $resp = $req.GetResponse()
            $resp.Close()
        } catch {
            # โฟลเดอร์อาจมีอยู่แล้ว ไม่เป็นไร
        }
    }
}

# Helper: ฟังก์ชันอัปโหลด 1 ไฟล์
function Upload-FtpFile {
    param (
        [string]$localRelativePath,
        [PSCustomObject]$cfg
    )

    $localFullPath = Join-Path $scriptDir $localRelativePath
    if (-not (Test-Path $localFullPath -PathType Leaf)) {
        Write-Host "  [-] ข้าม: ไม่พบไฟล์ในเครื่อง ($localRelativePath)" -ForegroundColor DarkGray
        return $false
    }

    $normRel = $localRelativePath.Replace('\', '/')
    $remoteRoot = $cfg.remote_root.TrimEnd('/')
    $remoteFullPath = "$remoteRoot/$normRel"

    # สร้างโฟลเดอร์แม่ก่อน
    $remoteDir = [System.IO.Path]::GetDirectoryName($remoteFullPath).Replace('\', '/')
    Ensure-FtpDirectory -remoteDirPath $remoteDir -cfg $cfg

    $ftpUri = "ftp://$($cfg.host):$($cfg.port)$remoteFullPath"

    try {
        $req = [System.Net.FtpWebRequest]::Create($ftpUri)
        $req.Credentials = New-Object System.Net.NetworkCredential($cfg.username, $cfg.password)
        $req.Method = [System.Net.WebRequestMethods+Ftp]::UploadFile
        $req.UseBinary = $true
        $req.UsePassive = $cfg.passive_mode
        $req.EnableSsl = $cfg.use_ssl
        $req.Timeout = 15000

        $fileBytes = [System.IO.File]::ReadAllBytes($localFullPath)
        $req.ContentLength = $fileBytes.Length

        $requestStream = $req.GetRequestStream()
        $requestStream.Write($fileBytes, 0, $fileBytes.Length)
        $requestStream.Close()

        $response = $req.GetResponse()
        $response.Close()

        Write-Host "  [✓] สำเร็จ: " -ForegroundColor Green -NoNewline
        Write-Host "$localRelativePath" -ForegroundColor White
        return $true
    } catch {
        Write-Host "  [✗] ล้มเหลว: " -ForegroundColor Red -NoNewline
        Write-Host "$localRelativePath ($($_.Exception.Message))" -ForegroundColor Yellow
        return $false
    }
}

# เมนูหลัก
Write-Header
Write-Host "โฮสต์ปลายทาง: $($config.host) (โฟลเดอร์: $($config.remote_root))" -ForegroundColor Cyan
Write-Host "ผู้ใช้งาน FTP: $($config.username)" -ForegroundColor Cyan
Write-Host ""
Write-Host "เลือกรูปแบบการอัปโหลด:" -ForegroundColor White
Write-Host "  1. อัปโหลดเฉพาะไฟล์ที่มีการแก้ไขใน Git Commit ล่าสุด (แนะนำ - เร็วและแม่นยำ)" -ForegroundColor Green
Write-Host "  2. อัปโหลดเฉพาะไฟล์ที่แก้ไขในรอบนี้ (ชุดงาน LINE Modal, Navbar, Tab ส่งหนังสือ)" -ForegroundColor Yellow
Write-Host "  3. อัปโหลดทั้งระบบ (Full Sync - ข้ามโฟลเดอร์ .git และไฟล์ขยะ)" -ForegroundColor White
Write-Host "  4. ทดสอบการเชื่อมต่อ FTP (Test Connection)" -ForegroundColor Cyan
Write-Host "  5. แก้ไขข้อมูลการตั้งค่า FTP (Edit Config)" -ForegroundColor Magenta
Write-Host "  0. ออกจากโปรแกรม" -ForegroundColor Gray
Write-Host ""

$choice = Read-Host "กรุณาเลือกหมายเลข (1-5, หรือ 0)"

switch ($choice) {
    "1" {
        Write-Host "`nกำลังตรวจสอบไฟล์ที่เปลี่ยนแปลงจาก Git Commit ล่าสุด..." -ForegroundColor Yellow
        $gitFiles = git diff-tree --no-commit-id --name-only -r HEAD
        if ($LASTEXITCODE -ne 0 -or [string]::IsNullOrWhiteSpace($gitFiles)) {
            Write-Host "ไม่พบข้อมูลจาก Git หรือยังไม่มีการ commit" -ForegroundColor Red
            break
        }
        $fileList = $gitFiles -split "`r?`n" | Where-Object { -not [string]::IsNullOrWhiteSpace($_) }
        Write-Host "พบไฟล์ที่แก้ไขจำนวน $($fileList.Count) ไฟล์:`n" -ForegroundColor Cyan

        $successCount = 0
        foreach ($f in $fileList) {
            if (Upload-FtpFile -localRelativePath $f -cfg $config) {
                $successCount++
            }
        }
        Write-Host "`n[✓] อัปโหลดเสร็จสิ้น ($successCount/$($fileList.Count) ไฟล์)" -ForegroundColor Green
    }

    "2" {
        Write-Host "`nกำลังอัปโหลดไฟล์ชุดงานล่าสุด (UI / Tab / Line Modal)..." -ForegroundColor Yellow
        $curFiles = @(
            "index.php",
            "content.php",
            "header.php",
            "footer.php",
            "images/line_group_qrcode.jpg",
            "admin/paper.php",
            "admin/folder.php",
            "admin/history.php",
            "admin/outside_all.php",
            "admin/menu_config.php",
            "admin/menu3.php",
            "admin/menu4.php",
            "admin/menu5.php"
        )
        $successCount = 0
        foreach ($f in $curFiles) {
            if (Upload-FtpFile -localRelativePath $f -cfg $config) {
                $successCount++
            }
        }
        Write-Host "`n[✓] อัปโหลดเสร็จสิ้น ($successCount/$($curFiles.Count) ไฟล์)" -ForegroundColor Green
    }

    "3" {
        $confirm = Read-Host "คุณต้องการอัปโหลดไฟล์ทั้งหมดในโปรเจกต์ใช่หรือไม่? (y/n)"
        if ($confirm -ne 'y' -and $confirm -ne 'Y') {
            Write-Host "ยกเลิกการทำงาน" -ForegroundColor Yellow
            break
        }
        Write-Host "`nกำลังรวบรวมไฟล์ทั้งหมดในโปรเจกต์..." -ForegroundColor Yellow
        $excludeDirs = @('.git', 'scratch', '.system_generated', '.vscode')
        $excludeFiles = @('ftp_config.json', 'deploy_ftp.ps1', 'deploy_ftp.bat', '.gitignore')

        $allFiles = Get-ChildItem -Path $scriptDir -Recurse -File | Where-Object {
            $rel = $_.FullName.Substring($scriptDir.Length).TrimStart('\', '/')
            $parts = $rel.Split('\', '/')
            $skip = $false
            foreach ($p in $parts) {
                if ($excludeDirs -contains $p) { $skip = $true; break }
            }
            if ($excludeFiles -contains $_.Name) { $skip = $true }
            -not $skip
        }

        Write-Host "พบไฟล์ทั้งหมด $($allFiles.Count) ไฟล์ กำลังเริ่มอัปโหลด...`n" -ForegroundColor Cyan
        $successCount = 0
        foreach ($fileItem in $allFiles) {
            $relPath = $fileItem.FullName.Substring($scriptDir.Length).TrimStart('\', '/')
            if (Upload-FtpFile -localRelativePath $relPath -cfg $config) {
                $successCount++
            }
        }
        Write-Host "`n[✓] อัปโหลดไฟล์ทั้งหมดเสร็จสิ้น ($successCount/$($allFiles.Count) ไฟล์)" -ForegroundColor Green
    }

    "4" {
        Write-Host "`nกำลังทดสอบการเชื่อมต่อ FTP ไปยัง $($config.host)..." -ForegroundColor Yellow
        try {
            $testUri = "ftp://$($config.host):$($config.port)$($config.remote_root)/"
            $req = [System.Net.FtpWebRequest]::Create($testUri)
            $req.Credentials = New-Object System.Net.NetworkCredential($config.username, $config.password)
            $req.Method = [System.Net.WebRequestMethods+Ftp]::ListDirectory
            $req.UsePassive = $config.passive_mode
            $req.EnableSsl = $config.use_ssl
            $req.Timeout = 10000

            $resp = $req.GetResponse()
            Write-Host "[✓] เชื่อมต่อสำเร็จ! เข้าถึงโฟลเดอร์ $($config.remote_root) ได้เรียบร้อย" -ForegroundColor Green
            $resp.Close()
        } catch {
            Write-Host "[✗] เชื่อมต่อไม่สำเร็จ: $($_.Exception.Message)" -ForegroundColor Red
            Write-Host "โปรดตรวจสอบ Host, Username, Password หรือสิทธิ์การเข้าถึง" -ForegroundColor Yellow
        }
    }

    "5" {
        Write-Host "`nกรุณากรอกข้อมูลการเชื่อมต่อ FTP ใหม่:" -ForegroundColor Yellow
        $h = Read-Host "FTP Host / IP [$($config.host)]"
        $u = Read-Host "FTP Username [$($config.username)]"
        $p = Read-Host "FTP Password" -AsSecureString
        $BSTR = [System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($p)
        $plain = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)
        $r = Read-Host "Remote Root Path [$($config.remote_root)]"

        if (-not [string]::IsNullOrWhiteSpace($h)) { $config.host = $h.Trim() }
        if (-not [string]::IsNullOrWhiteSpace($u)) { $config.username = $u.Trim() }
        if (-not [string]::IsNullOrWhiteSpace($plain)) { $config.password = $plain }
        if (-not [string]::IsNullOrWhiteSpace($r)) { $config.remote_root = $r.Trim() }

        $jsonStr = $config | ConvertTo-Json -Depth 4
        [System.IO.File]::WriteAllText($configFile, $jsonStr, [System.Text.Encoding]::UTF8)
        Write-Host "[✓] อัปเดตการตั้งค่าเรียบร้อยแล้ว!" -ForegroundColor Green
    }

    default {
        Write-Host "ออกจากโปรแกรม" -ForegroundColor Gray
    }
}

Write-Host ""
Write-Host "กดปุ่มใดๆ เพื่อปิดหน้าต่าง..." -ForegroundColor Gray
$null = [Console]::ReadKey()
