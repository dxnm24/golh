@extends('admin.layouts.master')

@section('title', 'Thêm game type')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.gametype.index') }}" class="btn btn-success">Danh sách game type</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form action="{{ route('admin.gametype.store') }}" method="POST">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Thêm game type</h3>
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
					<div class="form-group">
						<label for="parent_id">Mục cha</label>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('parent_id', $gameTypes, old('parent_id'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="home">Home</label>
						<p>Hiển thị ra trang chủ hay không?</p>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('home', CommonOption::statusArray(), old('home'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="type">Type</label>
						<p>Thể loại game? (hiển thị 2 tab ngoài trang chủ)</p>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('type', CommonOption::statusArray(), old('type'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="limited">Limited</label>
						<p>Số items hiển thị trên trang chủ</p>
						<div class="row">
							<div class="col-sm-8">
								<input name="limited" type="text" value="{{ old('limited') }}" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="sort_by">Sắp xếp</label>
						<p>Kiểu sắp xếp danh sách games (trang chủ)</p>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('sort_by', CommonOption::gameSortByArray(), old('sort_by'), array('class' =>'form-control')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="type">Grid</label>
						<p>Trang thể loại hiển thị dạng ô (không kích hoạt) hay dạng danh sách (kích hoạt)</p>
						<div class="row">
							<div class="col-sm-8">
							{!! Form::select('grid', CommonOption::statusArray(), old('grid'), array('class' =>'form-control')) !!}
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