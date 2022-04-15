<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ItemsController;

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

/*
/categories/
/categories/create
/categories/{id}/edit
/categories/{id}
/items/
/items/create
/items/{id}/edit
/items/{id}
*/


//view categories
Route::view('/', 'main');

Route::get('/categories', function() {
    return view('categories', ['categories'=>CategoriesController::getAllCategories()]);
})->name("categories");

Route::get('/categories/create', function() {
    return view('category_edit');
})->name("categoryCreateForm");

Route::get('/categories/{id}/delete', [CategoriesController::class,'requestDeleteCategory'])->name("categoryDelete");

Route::get('/categories/{id}/edit', [CategoriesController::class,'requestShowCategory'])->name("categoryEditForm");

//post categories
Route::patch('/categories/{id}', [CategoriesController::class,'requestEditCategory'])->name("editCategory");

Route::post('/categories/create', [CategoriesController::class,'requestAddCategory'])->name("createCategory");



//view item
Route::get('/items', function() {
    return view('items', ['items'=>ItemsController::getAllItems()]);
})->name("items");

Route::get('/items/create', [ItemsController::class,'requestCreateItemView'])->name("itemCreateForm");

Route::get('/items/{id}/delete', [ItemsController::class,'requestDeleteItems'])->name("itemDelete");

Route::get('/items/{id}/edit', [ItemsController::class,'requestShowItem'])->name("itemEditForm");

//post items
Route::patch('/items/{id}', [ItemsController::class,'requestEditItems'])->name("editItem");

Route::post('/items/create', [ItemsController::class,'requestAddItems'])->name("createItem");

