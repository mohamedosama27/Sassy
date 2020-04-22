<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', 'ItemController@showAll');
Route::get('/welcome', 'ItemController@welcome')->name('welcome');

Route::get('send-mail','MailSend@mailsend');
Route::get('chat/{id}','MessageController@show')->name('chat')->middleware('auth');
Route::get('changeStatus/{id}','MessageController@changeStatus')->name('changeStatus')->middleware('auth');

Route::post('getmessage','MessageController@getmessage')->name('getmessage')->middleware('auth');
Route::post('automatedmessage','MessageController@automatedmessage')->name('automatedmessage')->middleware('auth');

Route::post('getSenders','MessageController@getSenders')->name('getSenders')->middleware('auth');

Route::post('countmessage','MessageController@countmessage')->name('countmessage');

Route::post('/sendmessage', [
    'uses' => 'MessageController@create',
    'as' => 'sendmessage'
])->middleware('auth');


Route::get('/', 'ItemController@welcome')->name('home');
Route::get('/category/{id}', 'CategoryController@index')->name('category');

Route::get('/ItemController/action', 'ItemController@action')->name('ItemController.action');
Route::post('/add-to-cart', 'CartController@AddToCart')->name('item.addToCart');

Route::post('/decrementItem', [
    'uses' => 'CartController@decrementItem',
    'as' => 'decrementItem'
]);
Route::post('/incrementItem', [
    'uses' => 'CartController@incrementItem',
    'as' => 'incrementItem'
]);



Route::get('/home', [
    'uses' => 'ItemController@welcome',
    'as' => 'home'
]);
Route::put('/update/{id}',
[
    'uses' => 'ItemController@update',
    'as' => 'item.update'
])->middleware('auth','ifAdmin');
Route::get('/show/{id}', [
    'uses' => 'ItemController@show',
    'as' => 'item.show'
]);


Route::get('/accept/{id}', [
    'uses' => 'OrderController@accept',
    'as' => 'order.accept'
])->middleware('auth','ifAdmin');
Route::get('/reject/{id}', [
    'uses' => 'OrderController@reject',
    'as' => 'order.reject'
])->middleware('auth','ifAdmin');
Route::get('/deleteOrder/{id}', [
    'uses' => 'OrderController@destroy',
    'as' => 'order.delete'
])->middleware('auth','ifAdmin');

Route::get('/createitem',
[
    'uses' => 'ItemController@create',
    'as' => 'item.create'
])->middleware('auth','ifAdmin');
Route::put('/checkout',
[
    'uses' => 'OrderController@create',
    'as' => 'checkout'
])->middleware('auth');
Route::get('/deleteitem/{id}',
[
    'uses' => 'ItemController@destroy',
    'as' => 'item.delete'
])->middleware('auth','ifAdmin');
Route::get('/deleteimage/{id}',
[
    'uses' => 'ItemController@deleteImage',
    'as' => 'image.delete'
])->middleware('auth','ifAdmin');
Route::get('/edititem/{id}', [
    'uses' => 'ItemController@edit',
    'as' => 'item.edit'
])->middleware('auth','ifAdmin');
Route::put('/createcategory',
[
    'uses' => 'CategoryController@store',
    'as' => 'category.store'
])->middleware('auth','ifAdmin');
Route::get('/editcategory', [
    'uses' => 'CategoryController@edit',
    'as' => 'category.edit'
])->middleware('auth','ifAdmin');
Route::get('/deleteCategory/{id}', [
    'uses' => 'CategoryController@destroy',
    'as' => 'category.delete'
])->middleware('auth','ifAdmin');
Route::put('/updateCategory/{id}',
[
    'uses' => 'CategoryController@update',
    'as' => 'category.update'
])->middleware('auth','ifAdmin');


Route::get('/cart',
[
    'uses' => 'CartController@showCart',
    'as' => 'cart'
]);

Route::get('/removefromcart/{id}', [
    'uses' => 'CartController@removeItem',
    'as' => 'removefromcart'
]);



Route::get('/vieworders',[
    'uses' => 'OrderController@showAll',
    'as' => 'vieworders'
])->middleware('auth','ifAdmin');
Route::get('/viewmails','MessageController@index')->name('viewmails')->middleware('auth','ifAdmin');
Route::get('/Mail_us_Admin/reply','MessageController@store')->middleware('auth','ifAdmin');


Route::put('/storeitem', [
    'uses' => 'ItemController@store',
    'as' => 'item.store'
])->middleware('auth','ifAdmin');

Route::put('/addAdmin', [
    'uses' => 'Auth\RegisterController@createAdmin',
    'as' => 'addAdmin'
])->middleware('auth','ifAdmin');
Route::get('/addadminview', function () {
    return view('auth/addadmin');
})->name('addadminview')->middleware('auth','ifAdmin');

Route::get('/edituser/{id}', [
    'uses' => 'Auth\RegisterController@edit',
    'as' => 'user.edit'
])->middleware('auth');
Route::put('/updateuser/{id}', [
    'uses' => 'Auth\RegisterController@update',
    'as' => 'user.update'
]);
Route::get('autocomplete', 'ItemController@autocomplete')->name('autocomplete');

Route::get('/users','MessageController@showAll')->name('users')->middleware('auth','ifAdmin');
Route::post('/usersearch','MessageController@search')->name('user.search')->middleware('auth','ifAdmin');


Auth::routes();
Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\LoginController@handleFacebookCallback'); 


