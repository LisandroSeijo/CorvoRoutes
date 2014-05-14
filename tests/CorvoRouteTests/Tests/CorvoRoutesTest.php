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
}
