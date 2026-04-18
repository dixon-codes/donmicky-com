param()

$ftpHost = "ftp.donmicky.co.tz"
$ftpPort = 21
$ftpUser = "donmiklem@donmicky.co.tz"
$ftpPass = "Korogwe2023"

$remoteRoot = "/donmicky.co.tz/public_html"
$localRoot = $PSScriptRoot

$filesToUpload = @(
    "index.php",
    "about.php",
    "order.php",
    "linkpage\navbar.php",
    "linkpage\logo.php"
)

Write-Host "=============================" -ForegroundColor Cyan
Write-Host "Deploying Edited Files Only..." -ForegroundColor Cyan
Write-Host "=============================" -ForegroundColor Cyan

foreach ($relPath in $filesToUpload) {
    $localFile = Join-Path $localRoot $relPath
    $remotePath = "$remoteRoot/" + $relPath.Replace("\", "/")
    $uri = "ftp://${ftpHost}:${ftpPort}${remotePath}"
    
    try {
        $request = [System.Net.FtpWebRequest]::Create($uri)
        $request.Method = [System.Net.WebRequestMethods+Ftp]::UploadFile
        $request.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPass)
        $request.UseBinary = $true
        $request.UsePassive = $true
        
        $fileBytes = [System.IO.File]::ReadAllBytes($localFile)
        $request.ContentLength = $fileBytes.Length
        
        $stream = $request.GetRequestStream()
        $stream.Write($fileBytes, 0, $fileBytes.Length)
        $stream.Close()
        
        $response = $request.GetResponse()
        $response.Close()
        Write-Host "[OK] $remotePath" -ForegroundColor Green
    }
    catch {
        Write-Host "[FAIL] $remotePath - $($_.Exception.Message)" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "Deploy complete! Press any key to exit..." -ForegroundColor Cyan
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
