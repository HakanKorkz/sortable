<?php

namespace Korkz\Server\App\config;

use Exception;

class CorsHandler
{
    private string $allowedOriginsFile;
    private array $allowedOrigins;

    /**
     * @param string $allowedOriginsFile
     * @throws Exception
     */
    public function __construct(string $allowedOriginsFile)
    {
        $this->allowedOriginsFile = $allowedOriginsFile;
        $this->allowedOrigins = $this->readAllowedOrigins();
    }

    /**
     * @return void
     */
    public function handleCors(): void
    {
        $requestOrigin = $_SERVER['HTTP_ORIGIN'] ?? '';
        $referer = $_SERVER['HTTP_REFERER'] ?? 'http://localhost';
        if ($this->isOriginAllowed($requestOrigin, $referer)) {
            header('Access-Control-Allow-Origin: ' . $requestOrigin);
            header('Access-Control-Allow-Headers: Content-Type');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        } else {
            header('HTTP/1.1 403 Forbidden');
            header('Content-Type: text/plain; charset=utf-8');
            echo 'Yasaklı erişim isteğinde bulundunuz.';
            exit;
        }
    }

    /**
     * @throws Exception
     */
    private function readAllowedOrigins(): array
    {
        if (!file_exists($this->allowedOriginsFile) || !is_readable($this->allowedOriginsFile)) {
            throw new Exception('Allowed origins file does not exist or is not readable | İzin verilen kaynak dosyası mevcut değil veya okunamıyor');
        }
        $allowedOriginsJson = file_get_contents($this->allowedOriginsFile);
        $allowedOrigins = json_decode($allowedOriginsJson, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Allowed origins file is not a valid JSON file | İzin verilen kaynak dosyası geçerli bir JSON dosyası değil');
        }
        if (!is_array($allowedOrigins)) {
            throw new Exception('Allowed origins file does not contain an array | İzin verilen kaynak dosyası bir dizi içermiyor');
        }
        return $allowedOrigins;
    }

    private function isOriginAllowed(string $requestOrigin, string $referer): bool {
        foreach ($this->allowedOrigins as $allowedOriginsList) {
            foreach ($allowedOriginsList as $allowedOrigin) {
                if (str_starts_with($requestOrigin, $allowedOrigin) && str_starts_with($referer, $allowedOrigin)) {
                    return true;
                }
            }
        }
        return false;
    }
}
