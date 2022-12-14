<?php

use App\Http\Controllers\NotifikasiController;
use App\Models\Message;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


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

Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login.post');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/paket', 'PaketController@index')->name('paket');
    Route::get('/paket/show/{id}', 'PaketController@show');
    Route::get('/paket/upload', 'PaketController@upload');
    Route::post('/paket/upload', 'PaketController@doupload');
    Route::get('/paket/resend-notif/{id}', 'PaketController@resendNotif');
    Route::get('/paket/delete/{id}', 'PaketController@delete');
    Route::post('/paket/delete-all', 'PaketController@deleteAll');
    Route::get('/paket/update/{id}', 'PaketController@update');
    Route::get('/claim', 'PaketController@claim')->name('claim');
    Route::get('/crm-monitor', 'PaketController@crmMonitor')->name('crm-monitor');
    Route::any('/crm-monitor/update/{id}', 'PaketController@crmMonitorUpdate')->name('crm-monitor.update');
    Route::get('/rts', 'PaketController@rts')->name('rts');

    Route::get('setting/notifikasi', 'NotifikasiController@index')->name('notifikasi');
    Route::get('setting/notifikasi/credit', 'NotifikasiController@credit')->name('notifikasi.credit');
    Route::any('setting/notifikasi/store', 'NotifikasiController@store')->name('notifikasi.store');
    Route::any('setting/notifikasi/remove', 'NotifikasiController@remove')->name('notifikasi.remove');

    Route::get('setting/apiwa', 'ApiwaController@index')->name('apiwa');
    Route::get('setting/user', 'UserController@index')->name('users');
    Route::any('setting/user/store', 'UserController@store')->name('users.store');
    Route::any('setting/user/remove', 'UserController@remove')->name('users.remove');

    Route::get('/message', 'MessageController@index')->name('message');
    Route::get('/message/delete/{id}', 'MessageController@delete')->name('message.delete');    
    Route::post('/message/delete-all', 'MessageController@deleteAll')->name('message.delete-all');
    Route::get('test', function () {
        // $wa = App\Helpers\Wa::send(1, ['phone' => '085232843165', 'message' => 'test']);
        // return $wa;
        $message = new Message();
        $message->api_id = 1;
        $message->phone = '085232843165';
        $message->message = 'test';
        $message->save();
        $notifikasijob = App\Jobs\NotifikasiJob::dispatch($message);
    });
    
    Route::get('cek-resi',function (){
        echo "ok";
        Artisan::call('idexpress:resi');
    });
    
    Route::get('cek-message',function (){
        Artisan::call('message:send');
        echo "ok";
    });

    Route::get('telat',function (){
        Artisan::call('telat 7');
        echo "ok";
    });
});
