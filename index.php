<?php
require 'RedirectService.php';
$redirectService = new RedirectService();$domain = $_SERVER['HTTP_HOST'];$redirectUrl = $redirectService->getRedirectUrl($domain);

echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta id="viewport" name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title></title>
    <style>
        html,body,iframe{width: 100%;height: 100%;padding: 0;margin: 0}
        #wrap{width: 100%;height: 100%;}
        iframe{border: none;}
    </style>
</head>
<body>
<div id="wrap">
    <iframe id="redirectFrame" src=""></iframe>
</div>

<script>
    function setRedirectUrl(url) {
        var redirectFrame = document.getElementById('redirectFrame');
        redirectFrame.src = url;
    }

    function redirect() {
        var newUrl = "{$redirectUrl}";
        setRedirectUrl(newUrl);
    }

    document.addEventListener('DOMContentLoaded', function() {
        redirect();
    });
</script>
</body>
</html>
HTML;
?>
