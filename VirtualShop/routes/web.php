<?php

/*
|--------------------------------------------------------------------------
| Main Site
|--------------------------------------------------------------------------
|
|
*/

Route::get('/', [
    'uses' => 'ProductController@index',


]) -> name('home');

Route::get('/add-to-cart/{id}', [
    'uses' => 'ProductController@getAddToCart',
    'as' => 'product.addToCart'
]);

Route::get('/index', [
    'uses' => 'ProductController@index',
]);

Route::get('/product', [
    'uses' => 'ProductController@search',
]);

Route::post('/product', 'ProductController@search');
//Route::get('/product', 'ProductController@search');

Route::resource('/comments','CommentController');
Route::resource('/replies','ReplyController');
Route::resource('/ratings','RateController');

Route::get('/product-detail/{id}', [
    'uses' => 'ProductController@showProductDetail',
    'as' => 'product.showDetail'
]);
Route::get('/product-detail/{id}/commentDelete','CommentController@destroy');
Route::get('/product-detail/{id}/replyDelete','ReplyController@destroy');
Route::post('/ratings', 'RateController@store');
Route::post('/incrementItem', 'CartController@incrementItemQuantity');
Route::post('/decrementItem', 'CartController@decrementItemQuantity');
//Route::resource('/product-detail/{id}','CommentsController');
//Route::resource('/product-detail/{id}','RepliesController');
//Route::post('/replies/ajaxDelete','RepliesController@ajaxDelete');

Route::get('/checkout', 'CheckoutController@index');
Route::get('/checkout/remove/{item}', 'CartController@delete');

//Route::get('/checkout/payment', 'OrderController@index');
Route::get('/checkout/payment', 'OrderController@store');

Route::get('/order/{user}', 'OrderController@show');
Route::post('/order', 'OrderController@search');


Route::get('/register', 'RegistrationController@create');

Route::post('/register', 'RegistrationController@store');

Route::get('/login', 'SessionsController@create')->name('login');

Route::post('/login', 'SessionsController@store');

Route::get('/logout', 'SessionsController@destroy');

Route::get('/about', 'AboutController@index');

Route::get('/contact', 'ContactController@index');

Route::get('/privacy', 'PrivacyController@index');

Route::get('/terms', 'TermsController@index');

Route::get('/checkout', 'CheckoutController@index');

//Route::get('/payment', 'PaymentController@index');

//Route::get('/product', 'ProductController@index');

Route::get('/products/{product}', 'ProductController@show');

//Route::get('/order', 'OrderController@index');
// Route::get('/order/create', 'OrderController@create');
//Route::get('/orders/{order}', 'OrderController@show');

//Route::get('/user', 'UserController@index');
//Route::get('/users/{user}', 'UserController@show');



/*
|--------------------------------------------------------------------------
| Administration
|--------------------------------------------------------------------------
|
| 
|
*/

Route::get('/administration', 'AdministrationHomeController@index')->name('admin_home');
Route::get('/administration/home', 'AdministrationHomeController@index');

Route::get('/administration/login', 'AdministrationSessionsController@create')->name('admin_login');

Route::post('/administration/login', 'AdministrationSessionsController@store');

Route::get('/administration/logout', 'AdministrationSessionsController@destroy');

Route::get('/administration/users', 'AdministrationUsersController@index');
Route::get('/administration/users/create', 'AdministrationUsersController@create');
Route::post('/administration/users', 'AdministrationUsersController@store');

Route::get('/administration/categories', 'AdministrationCategoryController@index');
Route::get('/administration/categories/create', 'AdministrationCategoryController@create');
Route::post('/administration/categories', 'AdministrationCategoryController@store');
Route::get('/administration/categories/{category}', 'AdministrationCategoryController@edit');
Route::post('/administration/categories/update/{category}', 'AdministrationCategoryController@update');

Route::get('/administration/products', 'AdministrationProductController@index');
Route::get('/administration/products/create', 'AdministrationProductController@create');
Route::post('/administration/products', 'AdministrationProductController@store');
Route::get('/administration/products/{product}', 'AdministrationProductController@edit');
Route::post('/administration/products/update/{product}', 'AdministrationProductController@update');

// Route::get('/products/create', 'ProductController@create');
// Route::get('/products/{product}/edit', 'ProductController@edit');