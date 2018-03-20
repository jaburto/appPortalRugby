@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/plantillas') }}">Plantilla</a> :
@endsection
@section("contentheader_description", $plantilla->$view_col)
@section("section", "Plantillas")
@section("section_url", url(config('laraadmin.adminRoute') . '/plantillas'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Plantillas Edit : ".$plantilla->$view_col)

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
				{!! Form::model($plantilla, ['route' => [config('laraadmin.adminRoute') . '.plantillas.update', $plantilla->id ], 'method'=>'PUT', 'id' => 'plantilla-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'id_app_equipo')
					@la_input($module, 'desnombre')
					@la_input($module, 'numperiodo')
					@la_input($module, 'isactive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/plantillas') }}">Cancel</a></button>
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
	$("#plantilla-edit-form").validate({
		
	});
});
</script>
@endpush
