<?php

use Corvo\Routes\Components\CorvoRoutes;
use Corvo\Routes\Commands\CreateSectionCommand;

class CreateSectionTest extends TestCase {

    public function testCreateSection()
    {
        $corvoRoutes = new CorvoRoutes;

        $config  = $corvoRoutes->getConfig();
        $basePath    = $config['base_path'];

        $section = $basePath.'/MyNewSectionToTest';
        
        $pathsToCreate = array(
            'section'     => $section,
            'controllers' => $section.'/Controllers',
            'models'      => $section.'/Models',
            'views'       => $section.'/Views',
            'config'      => $section.'/Config'
        );

        $routeFile = $section.'/'.$config['routes_filename'];
        
        Artisan::call('corvo:section', array('section_name' => 'MyNewSectionToTest'));

        foreach($pathsToCreate as $path)
        {
            $this->assertTrue(
                is_dir($path)
            );
        }

        $this->assertTrue(is_file($routeFile));

        File::deleteDirectory($section);
    }
}
