<?php
$requestBody = file_get_contents('php://input');$data = json_decode($requestBody, true);

if (!is_array($data)) {
    http_response_code(400);
    die('无效的JSON请求正文');
}

$domain =$data['service_id'];
$ipAddr =$data['ip'];

if (!preg_match('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}):(\d+)$/',$ipAddr)) {
    http_response_code(400);
    die('无效的IP或端口');
}

$filePath = 'services.json';
if (!file_exists($filePath)) {
    file_put_contents($filePath, json_encode([]));
}

$lockFile = 'services.json.lock';$fp = fopen($lockFile, 'w+');
if (!flock($fp, LOCK_EX)) {
    die('无法获取锁');
}

$services = json_decode(file_get_contents($filePath), true);
$services[$domain] = $ipAddr;
file_put_contents($filePath, json_encode($services, JSON_PRETTY_PRINT));

flock($fp, LOCK_UN);
fclose($fp);
http_response_code(200);
echo "OK";
?>
