<?php

use Corvo\Routes\Components\CorvoRoutes;

class CorvoRoutesTests extends TestCase
{
    public function testRoutesAdded()
    {
        $corvoRoute = new CorvoRoutes();
        $corvoRoute->basePath(__DIR__.'/../AmazingSections')->load();

        $routes = Route::getRoutes();
        $sections = array('testBlog', 'testForo', 'testAdmin');

        foreach($sections as $section)
        {
            $isInRoutes = false;

            foreach($routes as $route)
            {
                if ($route->getPath() == $section)
                {
                    $isInRoutes = true;
                    break;
                }
            }

            $this->assertTrue($isInRoutes);
        }
    }

    public function testAlternativePaths()
    {
        $corvoRoute = new CorvoRoutes();
        $corvoRoute->basePath(__DIR__.'/../AmazingSections')
        ->alternativePaths(array(
            __DIR__.'/../Alternative'
        ))
        ->load();

        $routes = Route::getRoutes();
        $alternativeRoute = false;

        foreach(Route::getRoutes() as $route)
        {
            if ($route->getPath() == 'alternativeRoute')
            {
                $alternativeRoute = true;
                break;
            }
        }

        $this->assertTrue($alternativeRoute);
    }

    public function testViewNamespaces()
    {
        $corvoRoute = new CorvoRoutes();
        $corvoRoute->basePath(__DIR__.'/../AmazingSections')->load();

        $response = $this->call('GET', '/testAdmin');
        $data = $response->getContent();

        $this->assertEquals(
            $data, "<h1>Admin's section</h1>"
        );
    }

    public function testAlternativeViewNamespaces()
    {
        $corvoRoute = new CorvoRoutes();
        $corvoRoute->basePath(__DIR__.'/../AmazingSections')
        ->alternativePaths(array(
            __DIR__.'/../Alternative'
        ))
        ->load();

        $response = $this->call('GET', '/alternativeView');
        $data = $response->getContent();

        $this->assertEquals(
            $data, "<h1>Users section in alternative folder</h1>"
        );   
    }
}
