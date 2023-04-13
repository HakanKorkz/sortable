<?php

namespace Korkz\Server\App\test;

use Exception;
use Korkz\Server\App\router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /** @var Router */
    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetRoute()
    {
        $this->router->get('/user/{id}', function ($id) {
            echo "User ID: " . $id;
        });
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/user/123';
        ob_start();
        $this->router->dispatch();
        $output = ob_get_clean();
        $this->assertEquals('User ID: 123', $output);
    }

    /**
     * @throws Exception
     */
    public function testPostRoute()
    {
        $this->router->post('/user', function () {
            echo "New user created!";
        });
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/user';
        ob_start();
        $this->router->dispatch();
        $output = ob_get_clean();
        $this->assertEquals('New user created!', $output);
    }

    /**
     * @throws Exception
     */
    public function testInvalidRoute()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/invalid';
        ob_start();
        $this->router->dispatch();
        $output = ob_get_clean();
        $this->assertEquals('Aradığınız sayfa bulunamadı.', $output);
        $this->assertEquals(404, http_response_code());
    }

    /**
     * @throws Exception
     */
    public function testPutRoute()
    {
        $this->router->custom('PUT', '/user/{id}', function ($id) {
            echo "User ID: " . $id;
        });
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $_SERVER['REQUEST_URI'] = '/user/123';
        ob_start();
        $this->router->dispatch();
        $output = ob_get_clean();
        $this->assertEquals('User ID: 123', $output);
    }

    /**
     * @throws Exception
     */
    public function testPatchRoute()
    {
        $this->router->custom('PATCH', '/user/{id}', function ($id) {
            echo "User ID: " . $id;
        });
        $_SERVER['REQUEST_METHOD'] = 'PATCH';
        $_SERVER['REQUEST_URI'] = '/user/123';
        ob_start();
        $this->router->dispatch();
        $output = ob_get_clean();
        $this->assertEquals('User ID: 123', $output);
    }

    /**
     * @throws Exception
     */
    public function testDeleteRoute()
    {
        $this->router->custom('DELETE', '/user/{id}', function ($id) {
            echo "User ID: " . $id . " deleted.";
        });
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_SERVER['REQUEST_URI'] = '/user/123';
        ob_start();
        $this->router->dispatch();
        $output = ob_get_clean();
        $this->assertEquals('User ID: 123 deleted.', $output);
    }
}
