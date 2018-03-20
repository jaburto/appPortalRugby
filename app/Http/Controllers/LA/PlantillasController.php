<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Plantilla;

class PlantillasController extends Controller
{
	public $show_action = true;
	public $view_col = 'desnombre';
	public $listing_cols = ['id', 'id_app_equipo', 'desnombre', 'numperiodo', 'isactive'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Plantillas', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Plantillas', $this->listing_cols);
		}
	}

	/**
	 * Display a listing of the Plantillas.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Plantillas');

		if(Module::hasAccess($module->id)) {
			return View('la.plantillas.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new plantilla.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created plantilla in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Plantillas", "create")) {

			$rules = Module::validateRules("Plantillas", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$insert_id = Module::insert("Plantillas", $request);

			return redirect()->route(config('laraadmin.adminRoute') . '.plantillas.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified plantilla.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Plantillas", "view")) {

			$plantilla = Plantilla::find($id);
			if(isset($plantilla->id)) {
				$module = Module::get('Plantillas');
				$module->row = $plantilla;

				return view('la.plantillas.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('plantilla', $plantilla);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("plantilla"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified plantilla.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Plantillas", "edit")) {
			$plantilla = Plantilla::find($id);
			if(isset($plantilla->id)) {
				$module = Module::get('Plantillas');

				$module->row = $plantilla;

				return view('la.plantillas.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('plantilla', $plantilla);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("plantilla"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified plantilla in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Plantillas", "edit")) {

			$rules = Module::validateRules("Plantillas", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}

			$insert_id = Module::updateRow("Plantillas", $request, $id);

			return redirect()->route(config('laraadmin.adminRoute') . '.plantillas.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified plantilla from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Plantillas", "delete")) {
			//Plantilla::find($id)->delete();
			DB::table('Plantillas')->where('id', $id)->delete();
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.plantillas.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('plantillas')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Plantillas');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/plantillas/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				else if($col == 'isactive') {
				    $data->data[$i][$j] = ($data->data[$i][$j] == 1) ? '<span class="label label-success">Activo</span>':'<span class="label label-danger">Inactivo</span>';
				}
			}

			if($this->show_action) {
				$output = '';
				$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/plantillajugadors/?c='.$data->data[$i][0].'').'" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit">Jugadores</i></a>';

				if(Module::hasAccess("Plantillas", "edit")) {
					$output .= ' <a href="'.url(config('laraadmin.adminRoute') . '/plantillas/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("Plantillas", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.plantillas.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline', 'onsubmit' => 'return ConfirmDelete()']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
