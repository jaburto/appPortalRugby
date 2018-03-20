@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/accions') }}">Accion</a> :
@endsection
@section("contentheader_description", $accion->$view_col)
@section("section", "Accions")
@section("section_url", url(config('laraadmin.adminRoute') . '/accions'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Accions Edit : ".$accion->$view_col)

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
				{!! Form::model($accion, ['route' => [config('laraadmin.adminRoute') . '.accions.update', $accion->id ], 'method'=>'PUT', 'id' => 'accion-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'desnombre')
					@la_input($module, 'destemplate')
					@la_input($module, 'isactive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/accions') }}">Cancel</a></button>
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
	$("#accion-edit-form").validate({
		
	});
});
</script>
@endpush
