$tag = @"
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-BWWTCVQP6D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-BWWTCVQP6D');
</script>
"@

$files = Get-ChildItem -Path . -Recurse -Include *.html,*.php -File
foreach ($file in $files) {
    # Check if we should skip
    if ($file.FullName -match "\\node_modules\\" -or $file.FullName -match "\\.git\\") {
        continue
    }

    $content = [System.IO.File]::ReadAllText($file.FullName)
    if (-not $content.Contains("G-BWWTCVQP6D")) {
        $regex = [regex]::new("(?i)</head>")
        if ($regex.IsMatch($content)) {
            $newContent = $regex.Replace($content, "`n$tag`n</head>", 1)
            # Try to preserve original encoding if possible. WriteAllText defaults to UTF8 without BOM.
            [System.IO.File]::WriteAllText($file.FullName, $newContent, [System.Text.Encoding]::UTF8)
            Write-Host "Updated $($file.FullName)"
        }
    } else {
        Write-Host "Skipped $($file.FullName) - already has tag"
    }
}
