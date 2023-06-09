<?php

namespace Korkz\Server\App\config;

use Exception;

class CorsHandler
{
    private array $allowedOrigins;

    /**
     * @param string $allowedOriginsFile
     * @throws Exception
     */
    public function __construct(string $allowedOriginsFile)
    {
        $allowedOriginsJson = file_get_contents($allowedOriginsFile);
        $allowedOrigins = json_decode($allowedOriginsJson, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($allowedOrigins)) {
            throw new Exception('Allowed origins file does not contain an array | İzin verilen kaynak dosyası bir dizi içermiyor');
        }
        $this->allowedOrigins = $allowedOrigins;
    }

    /**
     * @return void
     */
    public function handleCors(): void
    {
        if (!empty($_SERVER['HTTP_ORIGIN'])) {
            $requestOrigin = filter_var(trim($_SERVER['HTTP_ORIGIN']), FILTER_VALIDATE_URL);
            $referer = filter_var(trim($_SERVER['HTTP_REFERER']), FILTER_VALIDATE_URL);
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                header('Access-Control-Allow-Origin: ' . "$requestOrigin");
                header('Access-Control-Allow-Headers: Content-Type');
                header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
                exit;
            }
            if ($this->isOriginAllowed($requestOrigin, $referer)) {
                header('Access-Control-Allow-Origin: ' . $requestOrigin);
                header('Access-Control-Allow-Headers: Content-Type');
                header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            } else {
                http_response_code(403);
                header('Content-Type: text/plain; charset=utf-8');
                echo 'Yasaklı erişim isteğinde bulundunuz.';
                exit;
            }
        }
        return;
    }

    /**
     * @param string $requestOrigin
     * @param string $referer
     * @return bool
     */
    private function isOriginAllowed(string $requestOrigin, string $referer): bool
    {
         $allowedOrigins=$this->allowedOrigins["allowedOrigins"];
        if (in_array("$requestOrigin/",$allowedOrigins) && in_array($referer,$allowedOrigins)) {
            return true;
        }

//        foreach ($this->allowedOrigins as $allowedOriginsList) {
//            foreach ($allowedOriginsList as $allowedOrigin) {
//                if (str_starts_with($requestOrigin, $allowedOrigin) && str_starts_with($referer, $allowedOrigin)) {
//                    return true;
//                }
//            }
//        }
        return false;
    }
}
