<?php

Route::get('/alternativeRoute', function()
{
    return 'Alternative path';
});

Route::get('/alternativeView', function()
{
    return View::make('Alternative::users');
});