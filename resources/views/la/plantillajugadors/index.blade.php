@extends("la.layouts.app")

@section("contentheader_title", "Jugadores")
@section("contentheader_description", "PlantillaJugadors listing")
@section("section", "PlantillaJugadors")
@section("sub_section", "Listing")
@section("htmlheader_title", "PlantillaJugadors Listing")

@section("headerElems")
@la_access("PlantillaJugadors", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Jugaddores</button>
@endla_access
@endsection

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>Actions</th>
			@endif
		</tr>
		</thead>
		<tbody>

		</tbody>
		</table>
	</div>
</div>

@la_access("PlantillaJugadors", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Jugadores</h4>
			</div>
			{!! Form::open(['action' => 'LA\PlantillaJugadorsController@store', 'id' => 'plantillajugador-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                  {{--  @la_form($module) --}}


				  @la_input($module, 'id_app_plantilla',$id_app_plantilla)
					{{-- @la_input($module, 'id_app_jugador') --}}

					<label class="col-sm-2 control-label">Multiselect</label>
	        <div class="col-sm-10">

						<select id="example-post" name="multiselect[]" multiple="multiple">
							@foreach ($lstjugadores as $j)
								<option value="{{ $j->id }}"> {{ $j->desnombre }}  {{ $j->desapellidopaterno }}  {{ $j->desapellidomaterno }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/multiselect/bootstrap-multiselect.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/multiselect/bootstrap-multiselect.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/plantillajugador_dt_ajax?c='.$id_app_plantilla.'') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#plantillajugador-add-form").validate({

	});
});
$(document).ready(function() {

		$('#example-post').multiselect({
				includeSelectAllOption: false,
				enableFiltering: true,
				buttonWidth: '400px'
		});
});
</script>
@endpush
