<?php

class RedirectService {
    private $services;

    public function __construct() {
        $this->loadServices();
    }

    private function loadServices() {
        $filePath = 'services.json';
        if (!file_exists($filePath)) {
            http_response_code(404);
            die('services.json file not found');
        }
        $servicesJson = file_get_contents($filePath);
        $this->services = json_decode($servicesJson, true);
    }

    public function getRedirectUrl($domain) {
        if (!isset($this->services[$domain])) {
            http_response_code(404);
            die('Domain not found in services.json');
        }

        $ipAddr =$this->services[$domain];
        if (!preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}:\d+/', $ipAddr,$matches)) {
            http_response_code(500);
            die('Invalid IP address format');
        }
        $cleanIp =$matches[0];

        // 获取当前请求的路径
        $urlParts = parse_url($_SERVER['REQUEST_URI']);
        $path = isset($urlParts['path']) ? $urlParts['path'] : '';
        if ($path && substr($path, 0, 1) !== '/') {
            $path = '/' .$path;
        }

        // 构建完整的跳转URL
        return "http://$cleanIp$path";
    }
}

?>
