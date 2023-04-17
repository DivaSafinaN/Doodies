<?php

use App\Http\Controllers\MyDayController;
use App\Http\Controllers\TaskAdditionals;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskGroupController;
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
Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::resource('my_day', MyDayController::class);
    Route::resource('task_groups', TaskGroupController::class);
    Route::resource('task_groups.tasks', TaskController::class);

    Route::put('/task_groups/{task_group}/tasks/{task}/complete', 'App\Http\Controllers\TaskAdditionals@complete')->name('task_groups.tasks.complete');
    Route::delete('/task_groups/{task_group}/tasks/{task}/incomplete', 'App\Http\Controllers\TaskAdditionals@incomplete')->name('task_groups.tasks.incomplete');
    Route::get('/completed_tasks', 'App\Http\Controllers\TaskAdditionals@comtask')->name('completed_tasks');
    Route::put('/task_groups/{task_group}/tasks/{task}/addtomyday', 'App\Http\Controllers\TaskAdditionals@addtomyday')->name('task_groups.tasks.addtomyday');
    Route::delete('/task_groups/{task_group}/tasks/{task}/removefrmyday', 'App\Http\Controllers\TaskAdditionals@removefrmyday')->name('task_groups.tasks.removefrmyday');
    Route::get('/trash', 'App\Http\Controllers\TaskAdditionals@trash')->name('trash');
    Route::put('/task_groups/{task_group}/tasks/{task}/restore', 'App\Http\Controllers\TaskAdditionals@restore')->name('task_groups.tasks.restore');
    Route::delete('/task_groups/{task_group}/tasks/{task}/delete', 'App\Http\Controllers\TaskAdditionals@delete')->name('task_groups.tasks.delete');

    Route::put('/my_day/{my_day}/complete', 'App\Http\Controllers\MyDayAdditionals@complete')->name('my_day.complete');
    Route::delete('/my_day/{my_day}/incomplete', 'App\Http\Controllers\MyDayAdditionals@incomplete')->name('my_day.incomplete');
    Route::put('/my_day/{my_day}/restore', 'App\Http\Controllers\MyDayAdditionals@restore')->name('my_day.restore');
    Route::delete('/my_day/{my_day}/delete', 'App\Http\Controllers\MyDayAdditionals@delete')->name('my_day.delete');

    // Route::get('/email', function(){
        // $taskreminder = \App\Models\Task::find(3);
        // $mydayreminder = MyDay::find(4);
        // return new MyDayReminder($mydayreminder);
        // Mail::to("divasafina@email.com")->send(new TaskReminder($taskreminder));
    // });
});

