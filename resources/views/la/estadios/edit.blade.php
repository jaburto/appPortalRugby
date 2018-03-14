@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/estadios') }}">Estadio</a> :
@endsection
@section("contentheader_description", $estadio->$view_col)
@section("section", "Estadios")
@section("section_url", url(config('laraadmin.adminRoute') . '/estadios'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Estadios Edit : ".$estadio->$view_col)

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
				{!! Form::model($estadio, ['route' => [config('laraadmin.adminRoute') . '.estadios.update', $estadio->id ], 'method'=>'PUT', 'id' => 'estadio-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/estadios') }}">Cancel</a></button>
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
	$("#estadio-edit-form").validate({
		
	});
});
</script>
@endpush
