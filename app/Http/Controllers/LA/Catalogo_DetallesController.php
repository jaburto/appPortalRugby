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

use App\Models\Catalogo_Detalle;

class Catalogo_DetallesController extends Controller
{
	public $show_action = true;
	public $view_col = 'desvalor';
	public $listing_cols = ['id', 'id_app_catalogo', 'desvalor', 'numvalor', 'numorden'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Catalogo_Detalles', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Catalogo_Detalles', $this->listing_cols);
		}
	}

	/**
	 * Display a listing of the Catalogo_Detalles.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$module = Module::get('Catalogo_Detalles');
  	$id_app_catalogo = $request->input('c');

		if(Module::hasAccess($module->id)) {
			return View('la.catalogo_detalles.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'id_app_catalogo' => $id_app_catalogo
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new catalogo_detalle.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created catalogo_detalle in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Catalogo_Detalles", "create")) {

			$rules = Module::validateRules("Catalogo_Detalles", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$insert_id = Module::insert("Catalogo_Detalles", $request);

			return redirect()->route(config('laraadmin.adminRoute') . '.catalogo_detalles.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified catalogo_detalle.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Catalogo_Detalles", "view")) {

			$catalogo_detalle = Catalogo_Detalle::find($id);
			if(isset($catalogo_detalle->id)) {
				$module = Module::get('Catalogo_Detalles');
				$module->row = $catalogo_detalle;

				return view('la.catalogo_detalles.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('catalogo_detalle', $catalogo_detalle);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("catalogo_detalle"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified catalogo_detalle.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Catalogo_Detalles", "edit")) {
			$catalogo_detalle = Catalogo_Detalle::find($id);
			if(isset($catalogo_detalle->id)) {
				$module = Module::get('Catalogo_Detalles');

				$module->row = $catalogo_detalle;

				return view('la.catalogo_detalles.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('catalogo_detalle', $catalogo_detalle);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("catalogo_detalle"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified catalogo_detalle in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Catalogo_Detalles", "edit")) {

			$rules = Module::validateRules("Catalogo_Detalles", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}

			$insert_id = Module::updateRow("Catalogo_Detalles", $request, $id);

			return redirect()->route(config('laraadmin.adminRoute') . '.catalogo_detalles.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified catalogo_detalle from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Catalogo_Detalles", "delete")) {
			Catalogo_Detalle::find($id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.catalogo_detalles.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(Request $request)
	{
		$id_app_catalogo = $request->input('c');

		$values = DB::table('catalogo_detalles')->select($this->listing_cols)->where('id_app_catalogo',$id_app_catalogo)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Catalogo_Detalles');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/catalogo_detalles/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}else if($col == "id_app_catalogo") {
				    $data->data[$i][$j] = '<span class="label label-success">'.$data->data[$i][$j].'</span>';
				}
			}

			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Catalogo_Detalles", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/catalogo_detalles/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("Catalogo_Detalles", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.catalogo_detalles.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
