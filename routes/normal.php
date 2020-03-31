<?php
Route::group(['prefix' => 'normal'], function() {
    Route::get('loginUser','Admin\LoginController@showNormalForm')->name('normal.login');
    Route::post('loginUser','Admin\LoginController@normalLogin')->name('normal.login.post');;
    Route::get('logoutUser','Admin\LoginController@logoutUser')->name('normal.logout');
    
    Route::group(['middleware' => ['auth:normal']],function ()
    {
        Route::get('/',function(){
            return view('others.dashboard.index');
        })->name('other.dashboard');
    });
});

?>