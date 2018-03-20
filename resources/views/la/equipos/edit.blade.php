@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/equipos') }}">Equipo</a> :
@endsection
@section("contentheader_description", $equipo->$view_col)
@section("section", "Equipos")
@section("section_url", url(config('laraadmin.adminRoute') . '/equipos'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Equipos Edit : ".$equipo->$view_col)

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
				{!! Form::model($equipo, ['route' => [config('laraadmin.adminRoute') . '.equipos.update', $equipo->id ], 'method'=>'PUT', 'id' => 'equipo-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'desnombre')
					@la_input($module, 'desnombrefemenino')
					@la_input($module, 'desnombrecomercial')
					@la_input($module, 'imglogo')
					@la_input($module, 'imgbanner')
					@la_input($module, 'desentrenamiento')
					@la_input($module, 'deshorario')
					@la_input($module, 'descontacto')
					@la_input($module, 'deswebsite')
					@la_input($module, 'desfacebook')
					@la_input($module, 'isactive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/equipos') }}">Cancel</a></button>
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
	$("#equipo-edit-form").validate({
		
	});
});
</script>
@endpush
