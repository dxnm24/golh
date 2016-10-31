@extends('admin.layouts.master')

@section('title', 'Game type')

@section('content')

@include('admin.gametype.search')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.gametype.create') }}" class="btn btn-primary">Thêm Game type</a>
		<a onclick="callupdate();" class="btn btn-success" id="loadMsg">Update Position</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Game type</h3><i> - Total: {{ $data->total() }}</i>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th><input type="checkbox" id="checkall" onClick="toggle(this)"></th>
						<th>Name</th>
						<th>URL</th>
						<th>Mục cha</th>
						<th>Home</th>
						<th>Type</th>
						<th>Status</th>
						<th>Position</th>
						<th style="width:240px;">Action</th>
					</tr>
					@foreach($data as $key => $value)
					<?php 
			            if($value->parent_id > 0) {
			                $parentSlug = CommonQuery::getFieldById('game_types', $value->parent_id, 'slug');
			                $gameTypeUrl = CommonUrl::getUrl2($parentSlug, $value->slug, 1);
			            } else {
			                $gameTypeUrl = CommonUrl::getUrl($value->slug, 1);
			            }
			        ?>
					<tr>
						<td><input type="checkbox" class="id" name="id[]" value="{{ $value->id }}"></td>
						<td>{{ $value->name }}</td>
						<td>{{ $gameTypeUrl }}</td>
						<td>{{ CommonQuery::getFieldById('game_types', $value->parent_id, 'name') }}</td>
						<td>{!! CommonOption::getStatus($value->home) !!}</td>
						<td>{!! CommonOption::getStatus($value->type) !!}</td>
						<td>{!! CommonOption::getStatus($value->status) !!}</td>
						<td><input type="text" name="position" value="{{ $value->position }}" size="5" class="onlyNumber" style="text-align: center;"></td>
						<td>
							<a href="{{ $gameTypeUrl }}" class="btn btn-success" target="_blank">Xem</a>
							<a href="{{ route('admin.gametype.edit', $value->id) }}" class="btn btn-primary">Sửa</a>
							<form method="POST" action="{{ route('admin.gametype.destroy', $value->id) }}" style="display: inline-block;">
								{{ method_field('DELETE') }}
								{{ csrf_field() }}
								<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
							</form>
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
		{{ $data->links() }}
	</div>
</div>

@include('admin.gametype.script')

@stop