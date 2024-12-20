<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum','verified'])->group(function () {

    // User 
    Route::get("/user", function(Request $request){
        return $request->user();
    } );

    Route::get("/users", function() {
        return User::paginate(2); // Adjust the number as needed
    });
    
});

require __DIR__.'/auth.php';
