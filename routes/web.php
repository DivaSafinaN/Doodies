<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MyDayAdditionals;
use App\Http\Controllers\MyDayController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TaskAdditionals;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskGroupController;
use App\Http\Controllers\UserController;
use App\Jobs\SendMyDayReminder;
use App\Mail\MyDayReminder;
use App\Mail\TaskReminder;
use App\Models\MyDay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::get('/register', [UserController::class,'register'])->name('register');
Route::post('/register', [UserController::class,'store'])->name('register');
Route::get('/login', [UserController::class,'login'])->name('login');
Route::post('/login', [UserController::class,'enter'])->name('login');

Route::group(['middleware' => 'auth'], function(){
    Route::post('/logout', [UserController::class,'__invoke'])->name('logout');
    Route::resource('my_day', MyDayController::class);
    Route::resource('task_groups', TaskGroupController::class);
    Route::resource('task_groups.tasks', TaskController::class);
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    
    Route::put('/task_groups/{task_group}/tasks/{task}/complete', [TaskAdditionals::class, 'complete'])->name('task_groups.tasks.complete');
    Route::delete('/task_groups/{task_group}/tasks/{task}/incomplete', [TaskAdditionals::class, 'incomplete'])->name('task_groups.tasks.incomplete');
    Route::get('/completed_tasks',  [TaskAdditionals::class, 'comtask'])->name('completed_tasks');
    Route::put('/task_groups/{task_group}/tasks/{task}/addtomyday', [TaskAdditionals::class, 'addtomyday'])->name('task_groups.tasks.addtomyday');
    Route::delete('/task_groups/{task_group}/tasks/{task}/removefrmyday', [TaskAdditionals::class, 'removefrmyday'])->name('task_groups.tasks.removefrmyday');
    Route::get('/trash', [TaskAdditionals::class, 'trash'])->name('trash');
    Route::put('/task_groups/{task_group}/tasks/{task}/restore', [TaskAdditionals::class, 'restore'])->name('task_groups.tasks.restore');
    Route::delete('/task_groups/{task_group}/tasks/{task}/delete', [TaskAdditionals::class, 'delete'])->name('task_groups.tasks.delete');
    Route::put('/task_groups/{task_group}/tasks/{task}/fileTgone', [TaskAdditionals::class, 'fileTgone'])->name('task_groups.tasks.fileTgone');
    
    Route::put('/my_day/{my_day}/complete', [MyDayAdditionals::class, 'complete'])->name('my_day.complete');
    Route::delete('/my_day/{my_day}/incomplete', [MyDayAdditionals::class, 'incomplete'])->name('my_day.incomplete');
    Route::put('/my_day/{my_day}/restore', [MyDayAdditionals::class, 'restore'])->name('my_day.restore');
    Route::delete('/my_day/{my_day}/delete', [MyDayAdditionals::class, 'delete'])->name('my_day.delete');
    Route::put('/my_day/{my_day}/filegone', [MyDayAdditionals::class, 'filegone'])->name('my_day.filegone');

    Route::get('/edit-profile',[UserController::class,'edit_profile'])->name('edit-profile');
    Route::put('/update-profile',[UserController::class,'update_profile'])->name('update-profile');
    Route::get('/edit-password',[UserController::class,'edit_password'])->name('edit-password');
    Route::put('/update-password',[UserController::class,'update_password'])->name('update-password');

    Route::group(['middleware' => 'is_admin'], function(){
        Route::get('/manage-user', [AdminController::class, 'index'])->name('admin.manage-user');
        Route::delete('/delete-user/{user}', [AdminController::class, 'delete'])->name('admin.delete-user');
    });
});

