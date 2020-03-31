<?php
//use Auth;
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
Route::get('getdata','ProductsController@index');
Route::resource('suppliers','SuppliersController');
Route::post('updateSupplier','SuppliersController@update');
Route::resource('expense','ExpensesController');
Route::get('expNames','ExpensesController@insertAll');
Route::get('expDetails','ExpensesController@insertNext');
Route::post('updateExpense','ExpensesController@update');
Route::resource('sites','SitesController');
Route::resource('exp','NewExpenseController');
Route::resource('bills','BillsController');
Route::get('fetchSites','BillsController@fetchSites');
Route::get('fetchExpenses','BillsController@fetchExpenses');
Route::get('insertSites','BillsController@insertAll');
Route::get('printExcel','BillsController@printExcel');
Route::get('exportExcel/{supplier}','BillsController@exportExcel');
Route::get('editUser','BillsController@editUser');
Route::resource('passwords','PasswordPromptsController');
Route::resource('role','RoleController');
Route::post('getRoles','RoleController@getRoles');
Route::post('checkpassword','PasswordPromptsController@checkPassword');
Route::post('confirm_password','PasswordPromptsController@confirmPassword');
Route::post('delete_password','PasswordPromptsController@deletePassword');
Route::post('revert_payment','BillsController@revertPayment');
Route::get('showBill','BillsController@showBill');
Route::post('editPaid','BillsController@editPaid');
Route::get('SupplierData','BillsController@SupplierData');
Route::get('fetchvat','BillsController@fetchVat');
Route::get('fetchtotal','BillsController@fetchTotal');
Route::get('return','BillsController@returnBill');
Route::post('updateBill','BillsController@update');
Route::get('updateDays','BillsController@updateDays');
Route::post('approveBill','BillsController@approveBill');
Route::post('updateUser','BillsController@updateUser');
Route::get('updateClearance','BillsController@payAlways');
Route::post('billsStore','BillsController@storeBills');
Route::post('addPayment','BillsController@addPayment');
Route::post('view','BillsController@viewPayment');
Route::get('pending','BillsController@pending');
Route::get('allBills','BillsController@allBills');
Route::get('printData','BillsController@printData');
Route::get('dynamic_pdf/{supplier}','BillsController@convert_customer_data_to_html');
Route::get('fetchUserBills','BillsController@addedBy');
Route::get('paid','BillsController@paid');
Route::get('paymultiple','BillsController@payMultiple');
Route::resource('materials','MaterialsController');
Route::get('fetchMaterials','MaterialsController@fetchMaterials');
Route::post('resetPassword','BillsController@resetPassword');
Route::post('registerUser','BillsController@registerUser');
Route::get('fetchDescription','MaterialsController@fetchDescription');
Route::get('fetchUsers','BillsController@fetchUsers');
Route::post('deleteUser','BillsController@deleteUser');
Route::get('fetchUsersData','BillsController@fetchUsersData');
Route::get('fetchSuppliers','SuppliersController@fetchSuppliers');
Route::get('notifyLatest','BillsController@returnLatest');
Route::post('updatePassword','BillsController@updatePassword');
Route::get('userproducts',function(){
    return view('userpanel');
});
Route::get('signup',function(){
    return view('auth.register');
});
Route::get('signin',function(){
    return view('auth.login');
});


//Route::get('fetchSites','SitesController@fetchSites');

Route::delete('bill/{id}','BillsController@destroy')->name('bill.destroy');
Route::delete('material/{id}','MaterialsController@destroy')->name('materials.destroy');
Auth::routes();
require_once('admin.php');
require_once('normal.php');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
