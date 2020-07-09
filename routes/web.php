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



Auth::routes(['verify' => false,'register' => false]);

Route::get('/{url?}', function(){
	return redirect('login');
})->where(['url' => '|home'])->name('home');

Route::group(['middleware' => ['auth']], function(){
	Route::get('access-denied', function(){
		return view('access-denied');
	})->name('access-denied');

		Route::resource('profile', 'ProfileController')->only(['index', 'store']);
        Route::group(['middleware' => ['check_permission'],'namespace'=>'Admin','prefix'=>'admin', 'as' => 'admin.'], function(){	

		Route::get('dashboard', 'DashboardController@index')->name('dashboard');
		
		Route::resource('profile', 'ProfileController')->only(['index', 'store']);

		Route::resource('settings', 'SettingsController')->only(['index', 'store']);

		// For Users
		Route::resources([
			'users' => 'UsersController',
			'project' => 'ProjectController',
			'subcontractor' => 'SubContractorController',
			'product_categories' => 'ProductCategories',
			'projecttype' => 'ProjectTypeController',
		]);
        Route::post('users/getUsers', 'UsersController@getUsers')->name('users.getUsers');
		Route::get('users/status/{user_id}', 'UsersController@status')->name('users.status');	

		//For Project
		Route::post('project/getproject', 'ProjectController@getProject')->name('project.getProject');
		Route::get('project/status/{id}', 'ProjectController@status')->name('project.status');

		// project preview 
		Route::get('projects/projectpreview/{id}', 'ProjectController@projectpreview')->name('projects.prereview');
		Route::get('projects/getpreview', 'ProjectController@getpreview')->name('projects.getpreview');
		Route::get('projects/addEnquiry/{id}', 'ProjectController@addEnquiry')->name('projects.addEnquiry');
		Route::get('projects/editenquiry/{id}', 'ProjectController@editenquiry')->name('projects.editenquiry');
		Route::post('projects/insertinquiry', 'ProjectController@insertinquiry')->name('projects.insertinquiry');
		Route::post('projects/updateEnquiry/{id}', 'ProjectController@updateEnquiry')->name('projects.updateEnquiry');
		Route::get('projects/addremarks/{id}', 'ProjectController@addremarks')->name('projects.addremarks');
		Route::post('projects/saveremark', 'ProjectController@saveremark')->name('projects.saveremark');


		// Route::get('project/destroy/{id}', 'ProjectController@destroy')->name('project.destroy');

		// For product_categories sub_contractor
		Route::post('product_categories/getProductCategories', 'ProductCategories@getProductCategories')->name('product_categories.getProductCategories');
        Route::get('product_categories/status/{id}', 'ProductCategories@status')->name('product_categories.status');

        // For sub_contractor
		Route::post('subcontractor/getSubContractors', 'SubContractorController@getSubContractors')->name('subcontractor.getSubContractors');
        Route::get('subcontractor/status/{id}', 'SubContractorController@status')->name('subcontractor.status');
       
         // For projecttype
		Route::post('projecttype/getProjectTypes', 'ProjectTypeController@getProjectTypes')->name('projecttype.getProjectTypes');
        Route::get('projecttype/status/{id}', 'ProjectTypeController@status')->name('projecttype.status');

        // For Countries
		Route::resource('countries', 'Countries')->except(['show']);
		Route::post('countries/list', 'Countries@getCountries')->name('countries.getCountries');
		Route::get('countries/status/{id}', 'Countries@status')->name('countries.status');	

         // For roles
		Route::resource('roles','RoleController');
		Route::get('roles/destroy/{id}', 'RoleController@destroy')->name('roles.destroy');
		Route::get('roles/status/{id}', 'RoleController@status')->name('roles.status');
	
        // For Cities
		Route::resource('cities', 'Cities')->except(['show']);
		Route::post('cities/list', 'Cities@getCities')->name('cities.getCities');
		Route::get('cities/status/{id}', 'Cities@status')->name('cities.status');
		Route::get('cities/updateDLS/{id}', 'Cities@updateDLS')->name('cities.updateDLS');	

		Route::resource('components','ComponentController');
    	Route::get('components/destroy/{id}', 'ComponentController@destroy')->name('components.destroy');
    	Route::get('components/status/{id}', 'ComponentController@status')->name('components.status');

	});

});