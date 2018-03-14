@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/arbitros') }}">Arbitro</a> :
@endsection
@section("contentheader_description", $arbitro->$view_col)
@section("section", "Arbitros")
@section("section_url", url(config('laraadmin.adminRoute') . '/arbitros'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Arbitros Edit : ".$arbitro->$view_col)

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
				{!! Form::model($arbitro, ['route' => [config('laraadmin.adminRoute') . '.arbitros.update', $arbitro->id ], 'method'=>'PUT', 'id' => 'arbitro-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'desnombre')
					@la_input($module, 'desapellidopaterno')
					@la_input($module, 'desapellidomaterno')
					@la_input($module, 'fecnacimiento')
					@la_input($module, 'isactive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/arbitros') }}">Cancel</a></button>
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
	$("#arbitro-edit-form").validate({
		
	});
});
</script>
@endpush
