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


Route::get('/', 'FrontpageController@index');
Route::get('show-post/{post}', 'FrontpageController@show')->name('frnt.show.post');


Auth::routes();

Route::group(['prefix'	=>	'dashboard'], function(){

	// Dashboard
	Route::get('', 'DashboardController@index')->name('dashboard.main');
	Route::get('profile/{employee}/employeesmedical/{employeesmedical}', 'DashboardController@show')->name('dashboard.show');

	// User Role
	Route::get('userRoles', 'UserRoleController@index')->name('dashboard.userRoles');
	Route::post('userRoles', 'UserRoleController@store')->name('dashboard.addUserRoles');
	Route::put('userRoles/{user_id}/{role_id}', 'UserRoleController@update')->name('dashboard.editUserRoles');

	// Roles
	Route::get('roles', 'RolesController@index')->name('dashboard.roles');
	Route::post('roles', 'RolesController@store')->name('dashboard.addRoles');
	Route::get('roles/{role}', 'RolesController@show')->name('dashboard.showRoles');
	Route::delete('roles/{role}', 'RolesController@destroy')->name('dashboard.deleteRole');

	// User
	Route::delete('users/{user}', 'UserController@destroy')->name('dashboard.delete.user');

});

Route::group(['prefix'	=>	'posts'], function(){

	Route::get('', 'PostController@index')->name('post.index');
	Route::get('create', 'PostController@create')->name('post.create');
	Route::get('create/featured/{ft_id}', 'PostController@searchImg')->name('getFtdImg');
	Route::get('edit/featured/{ft_id}', 'PostController@searchImg')->name('getFtdImgEdit');
	Route::post('create', 'PostController@store')->name('post.store');
	Route::get('{post}', 'PostController@show')->name('post.show');
	Route::get('{post}/edit', 'PostController@edit')->name('post.edit');
	Route::put('{post}/edit', 'PostController@update')->name('post.update');
	Route::delete('{post}', 'PostController@destroy')->name('post.destroy');
	// Upload Media
	Route::post('create/media', 'MediaController@store')->name('post.media');
	Route::post('{post}/edit/media', 'MediaController@addMediaOnPostUpdate');
	// Tags / Categories
	Route::post('create/tag', 'TagController@store')->name('add.tag');
	Route::post('edit/tag', 'TagController@store2')->name('add.tag2');
	// Route::post('{post}/edit/tag', 'TagController@store')->name('add.tag');
	Route::delete('{post}/tags/{tag_id}', 'PostTagController@destroy')->name('removeTags');

});

Route::group(['prefix'	=>	'category'], function(){

	Route::get('', 'TagController@index')->name('tag.index');
	Route::post('create', 'TagController@createTag')->name('store.tag');
	Route::put('{tag}/edit', 'TagController@update')->name('update.tag');
	Route::delete('{tag}', 'TagController@destroy')->name('destroy.tag');

});

Route::group(['prefix'	=>	'media'], function(){

	// Media
	Route::get('', 'MediaController@index')->name('media.index');
	Route::put('{media}/edit', 'MediaController@update')->name('media.edit');
	Route::delete('{media}', 'MediaController@destroy')->name('media.delete');

});

Route::group(['prefix' => 'hr'], function(){

	// Department
	Route::get('department', 'DepartmentController@index')->name('hr.dep.department');
	Route::post('department', 'DepartmentController@store')->name('hr.dep.addDep');
	Route::delete('department/{department}', 'DepartmentController@destroy')->name('hr.dep.deleteDep');

	// Position
	Route::get('position', 'PositionController@index')->name('hr.pos.position');
	Route::post('position', 'PositionController@store')->name('hr.pos.addPos');
	Route::get('position/{position}/department/{department}', 'PositionController@show')->name('hr.pos.show');
	Route::delete('position/{position}', 'PositionController@destroy')->name('hr.pos.deletePos');

	// Employee
	Route::get('employees', 'EmployeeController@index')->name('hr.employees');
	Route::get('employees/create', 'EmployeeController@create')->name('hr.emp.emp_form');
	Route::get('employees/create/deptID/{id}', 'EmployeeController@getPosition');
	Route::get('employees/create/EmpID/{emp_id}', 'EmployeeController@getEmpID');
	Route::post('employees', 'EmployeeController@store')->name('hr.emp.addEmp');
	Route::get('employees/print/', 'EmployeeController@printEmployees')->name('print.emp');
	Route::get('employees/printCsv', 'EmployeeController@printCsv'); //Route Print .CSV
	Route::get('employees/{employee}', 'EmployeeController@show')->name('hr.emp.show');
	Route::get('employees/{employee}/edit', 'EmployeeController@edit')->name('hr.emp.edit');
	Route::get('employees/edit/deptID/{id}', 'EmployeeController@getEditPosition');
	Route::put('employees/{employee}', 'EmployeeController@update')->name('hr.emp.store');

});

Route::group(['prefix' => 'employees'], function(){

	// Profile
	Route::get('profile', 'EmployeesProfileController@index')->name('employees');
	Route::get('profile/search', 'EmployeesProfileController@searchResult')->name('employee.search');
	Route::get('profile/employee/{employee}', 'EmployeesProfileController@show')->name('employee');
	Route::get('profile/employee', 'EmployeesProfileController@edit')->name('employee.edit');
	Route::put('profile/search/{emp_id}', 'EmployeesProfileController@update')->name('employee.update');
	// Route::get('profile/employee/{employee}', 'EmployeesProfileController@employeeMedicalRecord')->name('employeeRecord');

});

Route::group(['prefix' => 'inventory'], function(){

	// BrandName
	Route::get('medicine/brandname', 'MedbrandController@index')->name('brandname');
	Route::post('medicine/brandname', 'MedbrandController@store')->name('brandname.add');
	Route::delete('medicine/brandname/{medbrand}', 'MedbrandController@destroy')->name('brandname.delete');
	Route::get('medicine/brandname/{medbrand}', 'MedbrandController@show')->name('brandname.show');
	Route::put('medicine/brandname/{medbrand}', 'MedbrandController@update')->name('brandname.update');

	// Generic
	Route::get('medicine/generic', 'GenericController@index')->name('genericname');
	Route::post('medicine/generic', 'GenericController@store')->name('genericname.add');
	Route::delete('medicine/generic/{generic}', 'GenericController@destroy')->name('genericname.delete');
	Route::get('medicine/generic/{generic}', 'GenericController@show')->name('genericname.show');

	// Medicine
	Route::get('medicine', 'MedicineController@index')->name('medicine');
	Route::post('medicine', 'MedicineController@store')->name('medicine.add');
	Route::get('medicine/PrintMedCSV/', 'MedicineController@PrintMedCSV');
	
	Route::get('medicine/gen/{id}', 'MedicineController@getBrand');
	Route::get('medicine/logs/brand/{medbrand}/generic/{generic}', 'MedicineController@logs')->name('medicine.log');
	Route::get('medicine/logs/brand/{medbrand}/generic/{generic}/inputDate/{inputDate}/expDate/{expDate}', 'MedicineController@show')->name('medicine.show');

});

Route::group(['prefix' => 'medical'], function(){

	Route::get('employees/medical_record', 'EmployeesMedicalController@EmployeesWithRecord')->name('medical.empsRecords');
	Route::get('employees/full_report', 'EmployeesMedicalController@fullReport')->name('medical.fullReport');
	Route::get('employees', 'EmployeesMedicalController@listofEmployee')->name('medical.listsofemployees');
	Route::get('employees/{employee}', 'EmployeesMedicalController@employeeinfo')->name('medical.employeeInfo');
	// diagnosis
	Route::get('employees/diagnosis/{diagnosis}', 'DiagnosisController@fetchDiagnosis')->name('diagnosis.fetch');
	// 
	// Pre Employment
	Route::post('employees/{employee}/pre_employee', 'PreemploymentController@store')->name('medical.pre_emp');
	Route::get('pre_employment/{pre_emp}', 'PreemploymentController@download')->name('pre_emp.download');
	Route::delete('pre_employment/{preemployment}', 'PreemploymentController@destroy')->name('pre_emp.delete');
	// 
	Route::get('employees/gen/{id}', 'EmployeesMedicalController@getMedBrand')->name('getBrand');
	Route::post('employees/{employee}', 'EmployeesMedicalController@store')->name('medical.store');
	Route::get('employees/generic_id/{generic_id}/brand_id/{brand_id}', 'EmployeesMedicalController@getMedGenBrd')->name('getGenBrd');
	Route::get('employees/{employee}/employeesmedical/{employeesmedical}', 'EmployeesMedicalController@show')->name('medical.show');
	Route::get('employees/{employee}/employeesmedical/{employeesmedical}/generic_id/{generic_id}/brand_id/{brand_id}', 'EmployeesMedicalController@getMedGenBrdUpdate')->name('getMedGenBrdUpdate');
	Route::post('employees/{employee}/employeesmedical/{employeesmedical}', 'EmployeesMedicalController@storeFollowup')->name('medical.storeFollowup');
	Route::put('employees/{employee}/employeesmedical/{employeesmedical}', 'EmployeesMedicalController@update')->name('medical.update');
	Route::get('download/{file_name}', 'EmployeesMedicalController@download')->name('download');

});