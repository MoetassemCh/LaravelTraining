<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[ListingController::class,'index']);


//Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');


//Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update Listing 
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'delete'])->middleware('auth');
//Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');
//Show this last because it will override the other routes and breaks the app
//Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);



//Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//Create New User
Route::post('/users', [UserController::class, 'store']);

//Logout
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

//Show login Form

Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//Login User
Route::post('/users/authenticate',[UserController::class, 'authenticate']);



// Route::get('/listings/{listing}', function (Listing $listing) {
//     return view('listing', [
//         'listing' => $listing
//     ]);
// });



// Route::get('/listings/{id}',function($id){
//     $listing = Listing::find($id);
//     if($listing){
//         return view('listing',[
//             'listing'=>$listing
//         ]);
//     }else{
//         abort(404);
//     }
// });

