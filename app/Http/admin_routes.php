<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
	$as = config('laraadmin.adminRoute').'.';

	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

	/* ================== Dashboard ================== */

	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');

	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');

	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');

	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');

	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');

	/* ================== Departments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/departments', 'LA\DepartmentsController');
	Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', 'LA\DepartmentsController@dtajax');

	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', 'LA\EmployeesController');
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');

	/* ================== Organizations ================== */
	Route::resource(config('laraadmin.adminRoute') . '/organizations', 'LA\OrganizationsController');
	Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', 'LA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');

	/* ================== Arbitros ================== */
	Route::resource(config('laraadmin.adminRoute') . '/arbitros', 'LA\ArbitrosController');
	Route::get(config('laraadmin.adminRoute') . '/arbitro_dt_ajax', 'LA\ArbitrosController@dtajax');


	/* ================== Accions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/accions', 'LA\AccionsController');
	Route::get(config('laraadmin.adminRoute') . '/accion_dt_ajax', 'LA\AccionsController@dtajax');

	/* ================== Equipos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/equipos', 'LA\EquiposController');
	Route::get(config('laraadmin.adminRoute') . '/equipo_dt_ajax', 'LA\EquiposController@dtajax');


	/* ================== Jugadors ================== */
	Route::resource(config('laraadmin.adminRoute') . '/jugadors', 'LA\JugadorsController');
	Route::get(config('laraadmin.adminRoute') . '/jugador_dt_ajax', 'LA\JugadorsController@dtajax');

	/* ================== Catalogos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/catalogos', 'LA\CatalogosController');
	Route::get(config('laraadmin.adminRoute') . '/catalogo_dt_ajax', 'LA\CatalogosController@dtajax');

	/* ================== Catalogo_Detalles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/catalogo_detalles', 'LA\Catalogo_DetallesController');
	Route::get(config('laraadmin.adminRoute') . '/catalogo_detalle_dt_ajax', 'LA\Catalogo_DetallesController@dtajax');

	/* ================== Plantillas ================== */
	Route::resource(config('laraadmin.adminRoute') . '/plantillas', 'LA\PlantillasController');
	Route::get(config('laraadmin.adminRoute') . '/plantilla_dt_ajax', 'LA\PlantillasController@dtajax');

	/* ================== PlantillaJugadors ================== */
	Route::resource(config('laraadmin.adminRoute') . '/plantillajugadors', 'LA\PlantillaJugadorsController');
	Route::get(config('laraadmin.adminRoute') . '/plantillajugador_dt_ajax', 'LA\PlantillaJugadorsController@dtajax');
});
