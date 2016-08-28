@extends('admin.layouts.master')

@section('title', 'Thêm game tag')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.gametag.index') }}" class="btn btn-success">Danh sách game tag</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form action="{{ route('admin.gametag.store') }}" method="POST">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Thêm game tag</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="name">Name</label>
						<div class="row">
							<div class="col-sm-8">
								<input name="name" type="text" value="{{ old('name') }}" class="form-control" onkeyup="convert_to_slug(this.value);">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="slug">Slug</label>
						<div class="row">
							<div class="col-sm-8">
								<input name="slug" type="text" value="{{ old('slug') }}" class="form-control">
							</div>
						</div>
					</div>
					
					@include('admin.common.inputStatusLang', array('isCreate' => true))
					@include('admin.common.inputContent', array('isCreate' => true))
					@include('admin.common.inputMeta', array('isCreate' => true))
					
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