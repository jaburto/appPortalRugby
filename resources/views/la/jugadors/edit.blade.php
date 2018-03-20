@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/jugadors') }}">Jugador</a> :
@endsection
@section("contentheader_description", $jugador->$view_col)
@section("section", "Jugadors")
@section("section_url", url(config('laraadmin.adminRoute') . '/jugadors'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Jugadors Edit : ".$jugador->$view_col)

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
				{!! Form::model($jugador, ['route' => [config('laraadmin.adminRoute') . '.jugadors.update', $jugador->id ], 'method'=>'PUT', 'id' => 'jugador-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'id_app_equipo')
					@la_input($module, 'desnombre')
					@la_input($module, 'desapellidopaterno')
					@la_input($module, 'desapellidomaterno')
					@la_input($module, 'desalias')
					@la_input($module, 'imgfoto')
					@la_input($module, 'valposicion')
					@la_input($module, 'desheight')
					@la_input($module, 'desweight')
					@la_input($module, 'fecnacimiento')
					@la_input($module, 'valpais')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/jugadors') }}">Cancel</a></button>
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
	$("#jugador-edit-form").validate({
		
	});
});
</script>
@endpush
