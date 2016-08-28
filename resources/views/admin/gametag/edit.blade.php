@extends('admin.layouts.master')

@section('title', 'Sửa game tag')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.gametag.index') }}" class="btn btn-success">Danh sách game tag</a>
		<a href="{{ route('admin.gametag.create') }}" class="btn btn-primary">Thêm game tag</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form method="POST" action="{{ route('admin.gametag.update', $data->id) }}" accept-charset="UTF-8">
				<input name="_method" type="hidden" value="PUT">
				{!! method_field('PUT') !!}
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Sửa game tag</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="name">Name</label>
						<div class="row">
							<div class="col-sm-8">
								<input name="name" type="text" value="{{ $data->name }}" class="form-control" onkeyup="convert_to_slug(this.value);">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="slug">Slug</label>
						<div class="row">
							<div class="col-sm-8">
								<input name="slug" type="text" value="{{ $data->slug }}" class="form-control">
							</div>
						</div>
					</div>
					
					@include('admin.common.inputStatusLang', array('isEdit' => true))
					@include('admin.common.inputContent', array('isEdit' => true))
					@include('admin.common.inputMeta', array('isEdit' => true))
					
				</div>
				<div class="box-footer">
					<input type="submit" class="btn btn-primary" value="Lưu lại" />
					<input type="reset" class="btn btn-default" value="Nhập lại" />
				</div>
			</form>
		</div>
	</div>
</div>

@stop