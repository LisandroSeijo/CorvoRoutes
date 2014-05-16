#CorvoRoutes
Simple way to organize Laravel proyects.

If you wanna contribute, please, fork or open an [issue](https://github.com/LisandroSeijo/CorvoRoutes/issues).

If you have a question, sand me a [tweet](https://twitter.com/LisandroSeijo), or join on [Laraveles](http://laraveles.com/foro/) (Laravel in spanish).

#How to use

###Instalation
Add `"corvo/router"` in your composer.json requires and run `composer update`.
```
require {
    ...,
    "corvo/router": "dev-master"
}
```

Note: if you use namespaces in your sections add `app/web` with `psr-0` or `psr-4` on `composer.json`

```
autoload {
    "classmap": [
      ...
    ],
    "psr-0": {
      "": "app/web"
    }
}
```

Add `Corvo\Routes\Providers\CorvoRoutesServiceProvider` in your `app/config/app.php` file
```php
'providers' => array(
  'Illuminate\Foundation\Providers\ArtisanServiceProvider',
  ...
  'Corvo\Routes\Providers\CorvoRoutesServiceProvider'
)
```
Now, the easy way to create sections is using `artsian`, run the following command in your root application folder:
```
php artsian corvo:section [section_name]
```
That create a section called `[section_name]`. For example, lets to create a section for a blog
```
php artsian corvo:section Blog
```
And an admin section
```
php artsian corvo:section Admin
```
See in your `proyect/app` folder, and open the new folder named `web`, this contain all sections, and now we have the Blog and Admin sections.

You must have something like that:
```
|--app
|--|--web
|--|--|--Blog
|--|--|--|--Config
|--|--|--|--Controllers
|--|--|--|--Library
|--|--|--|--Models
|--|--|--|--routes.php
|--|--|--|--Views
|--|--|--Admin
|--|--|--|--Config
|--|--|--|--Controllers
|--|--|--|--Library
|--|--|--|--Models
|--|--|--|--routes.php
|--|--|--|--Views
```
###Namespaces
Now what we have the sections, go to create the views:
```php
/* app/web/Blog/Views/index.blade.php */

<h1>My Awsome Blog!</h1>

@foreach($posts as $post)
  <div>
    <h2>{{ $post->title }}</h2>
    <p>{{ $post->content }}</p>
  </div>
@endforeach
```
For access to this view, we can use the namespaces called in the same way as section.

Add in the Blog/routes.php file:

```php
/* app/web/Blog/routes.php */

Route::group(array('prefix' => 'blog'), function ()
{
  Route::get('/', function()
  {
    $posts = Blog\Models\Post::all();
    return View::make('Blog::index', ['posts' => $posts]);
  });
});
```
The Blog namespace is already added, and we can use that for do refence to all Blogs views.

The same way in our Admin views, and all sections:
```php
/* app/web/Admin/routes.php */

Route::group(array('prefix' => 'admin'), function ()
{
  Route::get('/users', function()
  {
    $users = Admin\Models\Users::all();
    return View::make('Admin::users', ['users' => $users]);
  });
});
```

To access to config files is the same way:
```php
/* app/web/Blog/Config/general.php */

return array(
  'posts_per_page' => 10
);
```
```php
/* app/web/Blog/Controllers/HomeController.php */

public function getIndex()
{
  $postsPerPage = Config::('Blog::general.posts_per_page');
  $posts = Blog\Models\Post::take($postsPerPage)->get();
  return View::make('Blog::index', ['posts' => $posts]);
}
```
#Runing
To run this, we need load CorvoRoutes class. To do that, in the `proyect/app/routes.php` file add the following line:
```php
/* app/routes.php */

CorvoRoutes::load();
```
And that's all.

#Advanced usage:

###Configuration
You can change the some features of CorvoRoutes like the path of sections, routes filename or the name of view folder.

In your `proyect/app/config` folder create a new config file called `corvoroutes`
```
|--app
|--|--config
|--|--|--corvoroutes.php
```
In this file, you can change one or more features.

Options:

| Name | Description |
| --- | --- |
| base_path | Change the base path of your sections location |
| alternative_paths | Array which contain the absolute path to other sections location |
| routes_filename | Name of your routes file |
| views_folder | Name of your views folder |

For example, if you wanna change the views folder `/Views` for `/Templates`, only add this option:

```php
/* proyect/app/config/corvoroutes.php */

return array(
    'views_folder' => 'Templates'
);
```
And change the `base_path`, you don't like `proyect/app/web` and think is better `proyect/content`:

```php
/* proyect/app/config/corvoroutes.php */

return array(
    'base_path'    => base_path().'/content',
    'views_folder' => 'Templates'
);
```
**Note:** if you change `base_path` and created previous sections in `proyect/app/web` you must move to the new base_path or add with `alternative_paths`

###Alternative paths
For add a section in other location like `proyect/content/Foro/` and `proyect/Users/` you have two was:

1) Using config file:
```php
return array(
    'alternative_paths' => array(
        base_path().'/content/Foro',
        base_path().'/Users'
    )
);
```
2) Using alternativePaths() method
```php
/* proyect/app/routes.php */

CorvoRoutes::alternativePaths(array(
    base_path().'/content/Foro',
    base_path().'/Users'
))
->load();
```
And each "alternative path" work like `proyect/app/web` sections.