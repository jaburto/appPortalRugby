@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/catalogo_detalles') }}">Catalogo Detalle</a> :
@endsection
@section("contentheader_description", $catalogo_detalle->$view_col)
@section("section", "Catalogo Detalles")
@section("section_url", url(config('laraadmin.adminRoute') . '/catalogo_detalles'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Catalogo Detalles Edit : ".$catalogo_detalle->$view_col)

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
				{!! Form::model($catalogo_detalle, ['route' => [config('laraadmin.adminRoute') . '.catalogo_detalles.update', $catalogo_detalle->id ], 'method'=>'PUT', 'id' => 'catalogo_detalle-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'id_app_catalogo')
					@la_input($module, 'desvalor')
					@la_input($module, 'numvalor')
					@la_input($module, 'numorden')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/catalogo_detalles') }}">Cancel</a></button>
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
	$("#catalogo_detalle-edit-form").validate({
		
	});
});
</script>
@endpush
