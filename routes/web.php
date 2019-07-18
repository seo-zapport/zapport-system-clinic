<?php

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

Route::group(['prefix'	=>	'dashboard'], function(){

	// Dashboard
	Route::get('', 'DashboardController@index')->name('dashboard.main');

	// User Role
	Route::get('userRoles', 'UserRoleController@index')->name('dashboard.userRoles');
	Route::post('userRoles', 'UserRoleController@store')->name('dashboard.addUserRoles');
	Route::put('userRoles/{user_id}/{role_id}', 'UserRoleController@update')->name('dashboard.editUserRoles');

	// Roles
	Route::get('roles', 'RolesController@index')->name('dashboard.roles');
	Route::post('roles', 'RolesController@store')->name('dashboard.addRoles');
	Route::delete('roles/{role}', 'RolesController@destroy')->name('dashboard.deleteRole');

});

Route::group(['prefix' => 'hr'], function(){

	// Department
	Route::get('department', 'DepartmentController@index')->name('hr.dep.department');
	Route::post('department', 'DepartmentController@store')->name('hr.dep.addDep');
	Route::delete('department/{department}', 'DepartmentController@destroy')->name('hr.dep.deleteDep');

	// Employee
	Route::get('employees', 'EmployeeController@index')->name('hr.employees');
	Route::get('employees/create', 'EmployeeController@create')->name('hr.emp.emp_form');
	Route::get('employees/create/deptID/{id}', 'EmployeeController@getPosition');
	Route::post('employees', 'EmployeeController@store')->name('hr.emp.addEmp');
	Route::get('employees/{employee}', 'EmployeeController@show')->name('hr.emp.show');
	Route::get('employees/{employee}/edit', 'EmployeeController@edit')->name('hr.emp.edit');
	Route::get('employees/edit/deptID/{id}', 'EmployeeController@getEditPosition');
	Route::put('employees/{employee}', 'EmployeeController@update')->name('hr.emp.store');

	// Position
	Route::get('position', 'PositionController@index')->name('hr.pos.position');
	Route::post('position', 'PositionController@store')->name('hr.pos.addPos');
	Route::delete('position/{position}', 'PositionController@destroy')->name('hr.pos.deletePos');

});

Route::group(['prefix' => 'employees'], function(){

	// Profile
	Route::get('profile', 'EmployeesProfileController@index')->name('employees');
	Route::get('profile/search', 'EmployeesProfileController@searchResult')->name('employee.search');
	Route::get('profile/employee/{employee}', 'EmployeesProfileController@show')->name('employee');
	Route::get('profile/employee', 'EmployeesProfileController@edit')->name('employee.edit');
	Route::put('profile/search/{emp_id}', 'EmployeesProfileController@update')->name('employee.update');

});

Route::group(['prefix' => 'inventory'], function(){

	// BrandName
	Route::get('medicine/brandname', 'MedbrandController@index')->name('brandname');
	Route::post('medicine/brandname', 'MedbrandController@store')->name('brandname.add');
	Route::delete('medicine/brandname/{medbrand}', 'MedbrandController@destroy')->name('brandname.delete');
	Route::get('medicine/brandname/{medbrand}', 'MedbrandController@show')->name('brandname.show');

	// Generic
	Route::get('medicine/generic', 'GenericController@index')->name('genericname');
	Route::post('medicine/generic', 'GenericController@store')->name('genericname.add');
	Route::delete('medicine/generic/{generic}', 'GenericController@destroy')->name('genericname.delete');

	// Medicine
	Route::get('medicine', 'MedicineController@index')->name('medicine');
	Route::post('medicine', 'MedicineController@store')->name('medicine.add');
	Route::get('medicine/brnd/{id}', 'MedicineController@getGeneric');
	Route::get('medicine/logs/brand/{medbrand}/generic/{generic}', 'MedicineController@logs')->name('medicine.log');
});