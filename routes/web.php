<?php

use App\Models\User;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;

use App\Http\Controllers\Frontend\IndexController;



//::middleware('admin.admin')->group(function(){
    Route::get('admin/login',[AdminController::class,'LoginForm']);
    Route::post('admin/login',[AdminController::class,'store'])->name('admin.login');

//}

//);

Route::middleware([ 'auth:sanctum,admin',config('jetstream.auth_session'), 
'verified'
])->group(function () {
    Route::get('/admin/dashboard',function () {
        return view('admin.index'); 
    })->name('dashboard');
});

// Admin All Routes

Route::get('/admin/logout',[AdminController::class,'destroy'])->name('admin.logout');

Route::get('/admin/profile',[AdminProfileController::class,'AdminProfile'])->name('admin.profile');

Route::get('/admin/profile/edit',[AdminProfileController::class,'AdminProfileEdit'])->name('admin.profile.edit');

Route::post('/admin/profile/store',[AdminProfileController::class,'AdminProfileStore'])->name('admin.profile.store');

Route::get('/admin/change/password',[AdminProfileController::class,'AdminChangePassword'])->name('admin.change.password');

Route::post('/update/change/password',[AdminProfileController::class,'AdminUpdateChangePassword'])->name('update.change.password');


// User ALL Routes

Route::middleware([ 'auth:sanctum,web',config('jetstream.auth_session'), 
'verified'
])->group(function () {
    Route::get('/dashboard',function () {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('dashboard',compact('user')); 
    })->name('dashboard');
});


Route::get('/',[IndexController::class,'index']);
Route::get('/user/logout',[IndexController::class,'UserLogout'])->name('user.logout');
Route::get('/user/profile',[IndexController::class,'UserProfile'])->name('user.profile');
Route::post('/user/profile/store',[IndexController::class,'UserProfileStore'])->name('user.profile.store');
Route::get('/user/change/password',[IndexController::class,'UserChangePassword'])->name('change.password');
Route::post('/user/password/update',[IndexController::class,'UserPasswordUpdate'])->name('user.password.update');


