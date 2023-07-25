<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\MyDayAdditionals;
use App\Http\Controllers\MyDayController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TaskAdditionals;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskGroupController;
use App\Http\Controllers\UserController;
use App\Mail\MyDayReminder;
use App\Mail\TaskReminder;
use App\Models\MyDay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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

Route::get('/register', [UserController::class,'register'])->name('register');
Route::post('/register', [UserController::class,'store'])->name('register');
Route::get('/login', [UserController::class,'login'])->name('login');
Route::post('/login', [UserController::class,'enter'])->name('login');

Route::group(['middleware' => 'auth'], function(){
    Route::post('/logout', [UserController::class,'__invoke'])->name('logout');
    Route::resource('task_groups', TaskGroupController::class);
    Route::resource('tasks', TaskController::class);
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/completed_tasks',  [TaskAdditionals::class, 'comtask'])->name('completed_tasks');
    Route::get('/trash', [TaskAdditionals::class, 'trash'])->name('trash');

    Route::post('/tasks/storeinTG',[TaskAdditionals::class,'store_inTG'])->name('tasks.store_inTG');
    
    Route::put('/tasks/{task}/complete', [TaskAdditionals::class, 'complete'])->name('tasks.complete');
    Route::delete('/tasks/{task}/incomplete', [TaskAdditionals::class, 'incomplete'])->name('tasks.incomplete');
    Route::delete('/tasks/{task}/removefrmyday', [TaskAdditionals::class, 'removefrmyday'])->name('tasks.removefrmyday');
    Route::put('/tasks/{task}/addtomyday', [TaskAdditionals::class, 'addtomyday'])->name('tasks.addtomyday');
    Route::put('/tasks/{task}/restore', [TaskAdditionals::class, 'restore'])->name('tasks.restore');
    Route::delete('/tasks/{task}/delete', [TaskAdditionals::class, 'delete'])->name('tasks.delete');
    Route::put('/tasks/{task}/fileTgone', [TaskAdditionals::class, 'fileTgone'])->name('tasks.fileTgone');
    Route::put('/tasks/{task}/to-taskgroup', [TaskAdditionals::class, 'addToTaskGroup'])->name('tasks.to-taskgroup');
    Route::delete('/tasks/{task}/no-taskgroup', [TaskAdditionals::class, 'delFrTaskGroup'])->name('tasks.no-taskgroup');

    Route::get('/edit-profile',[UserController::class,'edit_profile'])->name('edit-profile');
    Route::put('/update-profile',[UserController::class,'update_profile'])->name('update-profile');
    Route::get('/edit-password',[UserController::class,'edit_password'])->name('edit-password');
    Route::put('/update-password',[UserController::class,'update_password'])->name('update-password');

    Route::get('/calendar', [CalendarController::class,'index'])->name('calendar.index');
    Route::post('/calendar/store', [CalendarController::class,'store'])->name('calendar.store');
    Route::patch('/calendar/update/{id}', [CalendarController::class,'update'])->name('calendar.update');
    Route::delete('/calendar/destroy/{id}', [CalendarController::class,'destroy'])->name('calendar.destroy');

    Route::group(['middleware' => 'is_admin'], function(){
        Route::get('/manage-user', [AdminController::class, 'index'])->name('admin.manage-user');
        Route::delete('/delete-user/{user}', [AdminController::class, 'delete'])->name('admin.delete-user');
    });
});

