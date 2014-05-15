<?php namespace Corvo\Routes\Components;

use Illuminate\Support\Facades\File;
use Exception;

class CreateSection {

    protected $config;

    public function __construct()
    {
        $corvoRoutes = new CorvoRoutes;
        $config = $corvoRoutes->getConfig();

        $this->config = $config;
        $this->path   = $config['base_path'];
    }

    public function createSection($name)
    {
        $section = $this->path.'/'.$name;

        if ($this->existsSection($section))
        {
            throw new Exception('The section is already created');
        }

        $routes = $section.'/'.$this->config['routes_filename'];
        $controllers = $section.'/Controllers';
        $models = $section.'/Models';
        $views = $section.'/Views';
        $config = $section.'/Config';

        if (!File::makeDirectory($section, $mode = 0777, true, true))
        {
            throw new Exception('Error to create section folder on '.$section);
        }

        if (!File::put($routes, "<?php\n\n//Routes here..."))
        {
            throw new Exception('Error to create routes file on '.$routes);
        }

        if (!File::makeDirectory($controllers, $mode = 0777, true, true))
        {
            throw new Exception('Error to create controllers folder on '.$controllers);
        }

        if (!File::makeDirectory($models, $mode = 0777, true, true))
        {
            throw new Exception('Error to create models folder on '.$section);
        }

        if (!File::makeDirectory($views, $mode = 0777, true, true))
        {
            throw new Exception('Error to create viws folder on '.$views);
        }

        if (!File::makeDirectory($config, $mode = 0777, true, true))
        {
            throw new Exception('Error to create config folder on '.$views);
        }
    }

    public function existsSection($section)
    {
        return is_dir($section);
    }
}
