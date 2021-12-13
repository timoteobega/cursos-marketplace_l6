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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/product/{slug}', 'HomeController@single')->name('product.single');
Route::get('/category/{slug}', 'CategoryController@index')->name('category.single');
Route::get('/store/{slug}', 'StoreController@index')->name('store.single');

Route::prefix('cart')->name('cart.')->group(function(){

    Route::get('/','CartController@index')->name('index');
    Route::post('add','CartController@add')->name('add');
    Route::get('remove/{slug}','CartController@remove')->name('remove');
    Route::get('cancel','CartController@cancel')->name('cancel');

});

Route::prefix('checkout')->name('checkout.')->group(function(){

    Route::post('/proccess','CheckoutController@proccess')->name('proccess');
    Route::get('/','CheckoutController@index')->name('index');
    Route::get('/thanks','CheckoutController@thanks')->name('thanks');
    Route::post('/notification','CheckoutController@notification')->name('notification');

});

Route::get('/model', function(){
    //$products = \App\Product::all();
    //return $products;

    //$user = \App\User::find(50);
    //dd($user->store);
    //return $user->store;

    //pegar os produtos de uma loja
    //$loja = \App\Store::find(10);
    //return $loja->produtcs;
    //return $loja->produtcs->count();
    //return $loja->produtcs()->where('id',10)->get();

    //Pegar as lojas de uma categoria
    //$categoria = \App\Category::find(10);

    //Criar uma loja para um usuario
//    $user = \App\User::find(50);
//    $store = $user->store()->create([
//        'name' => 'Loja Teste',
//        'description' => 'Loja Teste de produtos de informatica',
//        'mobile_phone' => 'XX-XXXX-XXXX',
//        'phone' => 'XX-XXXXX-XXXX',
//        'slug' => 'loja-teste',
//    ]);
//    dd($store); // store id 121

    //Criar um produto para uma loja
//    $store = \App\Store::find(121);
//    $product = $store->products()->create([
//        'name' => 'Notebook Dell',
//        'description' => 'Core I5 10G 16GB Ram 256GB SSD',
//        'body' => 'Tela HD, Cor Preta, Bateria de 6 células',
//        'price' => 3789.99,
//        'slug' => 'notebook-dell',
//    ]);
//    dd($product);

    //Criar uma categoria
//    $category = \App\Category::create([
//        'name' => 'Games',
//        'description' => null,
//        'slug' => 'games',
//    ]);
//
//    $category = \App\Category::create([
//        'name' => 'Notebooks',
//        'description' => null,
//        'slug' => 'notebooks',
//    ]);
//
//    return \App\Category::all();

    //Adicionar um produto para uma categoria ou vice-versa
    //$product = \App\Product::find(30);
    //dd($product->categories()->attach([1]));
    //dd($product->categories()->detach([1]));
    //dd($product->categories()->sync([1,2]));
    //dd($product->categories()->sync([2]));

    //return $product->categories;
});
/*
Route::get
Route::post
Route::put
Route::patch
Route::delete
Route::options
Route::get('/admin/stores','Admin\\StoreController@index');
Route::get('/admin/stores/create','Admin\\StoreController@create');
Route::post('/admin/stores/store','Admin\\StoreController@store');
*/

Route::get('my-orders', 'UserOrderController@index')->name('user.orders')->middleware('auth');

Route::group(['middleware' => ['auth', 'access.control.store.admin']], function(){

    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function(){

        /*Route::prefix('stores')->name('stores.')->group(function(){

            Route::get('/','StoreController@index')->name('index');
            Route::get('/create','StoreController@create')->name('create');
            Route::post('/store','StoreController@store')->name('store');
            Route::get('/{store}/edit','StoreController@edit')->name('edit');
            Route::post('/update/{store}','StoreController@update')->name('update');
            Route::get('/destroy/{store}','StoreController@destroy')->name('destroy');

        });*/

        Route::resource('stores','StoreController');
        Route::resource('products','ProductController');
        Route::resource('categories','CategoryController');
        Route::post('photos/remove','ProductPhotoController@removePhoto')->name('photo.remove');
        Route::get('orders/my','OrdersController@index')->name('orders.my');
        Route::get('notifications','NotificationController@notifications')->name('notifications.index');
        Route::get('notifications/read-all','NotificationController@readAll')->name('notifications.read.all');
        Route::get('notifications/read/{notification}','NotificationController@read')->name('notifications.read');

        /*    Route::prefix('products')->name('products.')->group(function(){

                Route::get('/','ProductController@index')->name('index');
                Route::get('/create','ProductController@create')->name('create');
                Route::post('/store','ProductController@store')->name('store');
                Route::get('/{store}/edit','ProductController@edit')->name('edit');
                Route::post('/update/{store}','ProductController@update')->name('update');
                Route::get('/destroy/{store}','ProductController@destroy')->name('destroy');

            });*/

    });

});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');//->middleware('auth');

Route::get('not', function(){
    $user = \App\User::find(161);
    //$user->notify(new \App\Notifications\StoreReceivedNewOrder());
    //$notification = $user->notifications->first();
    //$notification->markAsRead();

    $stores = [119,121,122];
    $stores = \App\Store::whereIn('id',$stores)->get();

    /*return $stores->each(function($store){
        return $store->user;
    });*/

    return $stores->map(function($store){
        return $store->user;
    });

    //return $user->readNotifications->count();
});
