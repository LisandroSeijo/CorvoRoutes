<?php

Route::get('/testAdmin', function()
{
    return View::make('Admin::index');
});