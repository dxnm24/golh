@extends('admin.layouts.master')

@section('title', 'Sửa game')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.game.index') }}" class="btn btn-success">Danh sách game</a>
		<a href="{{ route('admin.game.create') }}" class="btn btn-primary">Thêm game</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form method="POST" action="{{ route('admin.game.update', $data->id) }}" accept-charset="UTF-8">
				<input name="_method" type="hidden" value="PUT">
				{!! method_field('PUT') !!}
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Sửa game</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label for="name">Name</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="name" type="text" value="{{ $data->name }}" class="form-control" onkeyup="convert_to_slug(this.value);">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="slug">Slug</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="slug" type="text" value="{{ $data->slug }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="type">Loại game</label>
								<div class="row">
									<div class="col-sm-12">
									{!! Form::select('type', CommonOption::typeGameArray(), $data->type, array('class' => 'form-control')) !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="url">Đường dẫn file game</label>
								<p>
									GameHTML5: /game-html5/ten-thu-muc-game/index.html<br>
									GameFlash: /game-flash/ten-file-game.swf<br>
									Game từ url ngoài: http://slither.io
								</p>
								<div class="row">
									<div class="col-sm-12">
										<input name="url" type="text" value="{{ $data->url }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="width-height">Cỡ khung game</label>
								<p>
									Width x Height. Mặc định: {{ FRAME_WIDTH }}x{{ FRAME_HEIGHT }}
								</p>
								<div class="row">
									<div class="col-sm-4">
										<input name="width" type="text" value="{{ $data->width }}" class="form-control" placeholder="Width">
									</div>
									<div class="col-sm-4">
										<input name="height" type="text" value="{{ $data->height }}" class="form-control" placeholder="Height">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="screen">Kiểu màn hình game</label>
								<div class="row">
									<div class="col-sm-12">
										{!! Form::select('screen', CommonOption::screenArray(), $data->screen, array('class' => 'form-control')) !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="play">Chơi trên mobile bằng iframe</label>
								<p>
									Game không chơi được trên iframe nên chuyển về trạng thái không kích hoạt (để chơi trên mobile bằng đường dẫn trực tiếp tới game)
								</p>
								<div class="row">
									<div class="col-sm-12">
										{!! Form::select('play', CommonOption::statusArray(), $data->play, array('class' => 'form-control')) !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="start_date">Ngày đăng</label>
								<div class="row">
									<div class="col-sm-6">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input name="start_date" type="text" value="{{ CommonMethod::datetimeToArray($data->start_date, 1) }}" class="form-control pull-right datepicker">
						                </div>
									</div>
									<div class="col-sm-6">
										<div class="bootstrap-timepicker">
											<div class="input-group">
												<input name="start_time" type="text" value="{{ CommonMethod::datetimeToArray($data->start_date, 2) }}" class="form-control timepicker">
												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>	
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							@include('admin.game.gametype', array('isEdit' => true, 'data' => $data))
							@include('admin.game.gametag', array('isEdit' => true, 'data' => $data))
						</div>
						<div class="col-sm-12">
							@include('admin.common.inputStatusLang', array('isEdit' => true))
							@include('admin.common.inputContent', array('isEdit' => true))
							@include('admin.common.inputMeta', array('isEdit' => true))
						</div>
					</div>
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