#CorvoRoutes
Simple way to organize Laravel proyects.

If you wanna contribute, please, fork or open an [issue](https://github.com/LisandroSeijo/CorvoRoutes/issues).

If you have a question, sand me a [tweet](https://twitter.com/LisandroSeijo), or join on [Laraveles](http://laraveles.com/foro/) (Laravel in spanish).

#How to use
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
    psr-0: {
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
#Namespaces
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
}
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
}
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