@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/plantillajugadors') }}">PlantillaJugador</a> :
@endsection
@section("contentheader_description", $plantillajugador->$view_col)
@section("section", "PlantillaJugadors")
@section("section_url", url(config('laraadmin.adminRoute') . '/plantillajugadors'))
@section("sub_section", "Edit")

@section("htmlheader_title", "PlantillaJugadors Edit : ".$plantillajugador->$view_col)

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

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($plantillajugador, ['route' => [config('laraadmin.adminRoute') . '.plantillajugadors.update', $plantillajugador->id ], 'method'=>'PUT', 'id' => 'plantillajugador-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'id_app_plantilla')
					@la_input($module, 'id_app_jugador')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/plantillajugadors') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#plantillajugador-edit-form").validate({
		
	});
});
</script>
@endpush
