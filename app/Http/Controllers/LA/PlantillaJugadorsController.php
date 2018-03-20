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

use App\Models\PlantillaJugador;
use App\Models\Jugador;

class PlantillaJugadorsController extends Controller
{
	public $show_action = true;
	public $view_col = 'id_app_plantilla';
	//public $listing_cols = ['id', 'id_app_plantilla', 'id_app_jugador'];
	public $listing_cols = ['id', 'id_app_jugador'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('PlantillaJugadors', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('PlantillaJugadors', $this->listing_cols);
		}
	}

	/**
	 * Display a listing of the PlantillaJugadors.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$module = Module::get('PlantillaJugadors');
		$id_app_plantilla = $request->input('c');
		//$values = DB::table('plantillajugadors')->select('id')->whereNull('deleted_at')->get();
		//$values2 = DB::table('jugadors')->whereNotIn('id', collect($values)->toArray())->get();
		$values = DB::table('jugadors')->select('jugadors.*')
							->leftJoin('PlantillaJugadors', function($join) use ($id_app_plantilla){
								$join->on('jugadors.id', '=', 'PlantillaJugadors.id_app_jugador')
								->where('PlantillaJugadors.id_app_plantilla', '=', $id_app_plantilla );
							 })
							//->leftJoin('PlantillaJugadors', , '=', )
							->whereNull('jugadors.deleted_at')
							//->where('PlantillaJugadors.id_app_plantilla',7)
							->whereNull('PlantillaJugadors.id_app_jugador')
							->get();

		//echo $values;
		if(Module::hasAccess($module->id)) {
			return View('la.plantillajugadors.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'id_app_plantilla' => $id_app_plantilla,
				'lstjugadores' => $values,
				'c'=>$id_app_plantilla,
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new plantillajugador.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created plantillajugador in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("PlantillaJugadors", "create")) {

			$rules = Module::validateRules("PlantillaJugadors", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}


			$news = $request->input('multiselect');
			foreach($news as $val)
      {
				$request['id_app_jugador'] = $val;
				Module::insert("PlantillaJugadors", $request);
			}
			//$insert_id = Module::insert("PlantillaJugadors", $request);

			//return redirect()->route(config('laraadmin.adminRoute') . '.plantillajugadors.index');
			return redirect()->route(config('laraadmin.adminRoute') . '.plantillajugadors.index', ['c' => $request['id_app_plantilla']]);

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified plantillajugador.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("PlantillaJugadors", "view")) {

			$plantillajugador = PlantillaJugador::find($id);
			if(isset($plantillajugador->id)) {
				$module = Module::get('PlantillaJugadors');
				$module->row = $plantillajugador;

				return view('la.plantillajugadors.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('plantillajugador', $plantillajugador);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("plantillajugador"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified plantillajugador.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("PlantillaJugadors", "edit")) {
			$plantillajugador = PlantillaJugador::find($id);
			if(isset($plantillajugador->id)) {
				$module = Module::get('PlantillaJugadors');

				$module->row = $plantillajugador;

				return view('la.plantillajugadors.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('plantillajugador', $plantillajugador);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("plantillajugador"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified plantillajugador in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("PlantillaJugadors", "edit")) {

			$rules = Module::validateRules("PlantillaJugadors", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}

			$insert_id = Module::updateRow("PlantillaJugadors", $request, $id);

			return redirect()->route(config('laraadmin.adminRoute') . '.plantillajugadors.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified plantillajugador from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("PlantillaJugadors", "delete")) {
			$PlantillaJugadors = PlantillaJugador::find($id);
			DB::table('PlantillaJugadors')->where('id', $id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.plantillajugadors.index',['c' => $PlantillaJugadors->id_app_plantilla]);
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
		$id_app_plantilla = $request->input('c');

		$values = DB::table('plantillajugadors')->select($this->listing_cols)
		->where('id_app_plantilla',$id_app_plantilla)
		->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('PlantillaJugadors');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/plantillajugadors/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}

			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("PlantillaJugadors", "edit")) {
					//$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/plantillajugadors/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("PlantillaJugadors", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.plantillajugadors.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline', 'onsubmit' => 'return ConfirmDelete()']);
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
