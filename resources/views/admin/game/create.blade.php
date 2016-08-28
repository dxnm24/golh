@extends('admin.layouts.master')

@section('title', 'Thêm game')

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ route('admin.game.index') }}" class="btn btn-success">Danh sách game</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<form action="{{ route('admin.game.store') }}" method="POST">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">Thêm game</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label for="name">Name</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="name" type="text" value="{{ old('name') }}" class="form-control" onkeyup="convert_to_slug(this.value);">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="slug">Slug</label>
								<div class="row">
									<div class="col-sm-12">
										<input name="slug" type="text" value="{{ old('slug') }}" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="type">Loại game</label>
								<div class="row">
									<div class="col-sm-12">
									{!! Form::select('type', CommonOption::typeGameArray(), old('type'), array('class' => 'form-control')) !!}
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
										<input name="url" type="text" value="{{ old('url') }}" class="form-control">
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
										<input name="width" type="text" value="{{ old('width') }}" class="form-control" placeholder="Width">
									</div>
									<div class="col-sm-4">
										<input name="height" type="text" value="{{ old('height') }}" class="form-control" placeholder="Height">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="screen">Kiểu màn hình game</label>
								<div class="row">
									<div class="col-sm-12">
										{!! Form::select('screen', CommonOption::screenArray(), old('screen'), array('class' => 'form-control')) !!}
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
										{!! Form::select('play', CommonOption::statusArray(), old('play'), array('class' => 'form-control')) !!}
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
											<input name="start_date" type="text" value="{{ old('start_date') }}" class="form-control pull-right datepicker">
						                </div>
									</div>
									<div class="col-sm-6">
										<div class="bootstrap-timepicker">
											<div class="input-group">
												<input name="start_time" type="text" class="form-control timepicker">
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
							@include('admin.game.gametype', array('isCreate' => true))
							@include('admin.game.gametag', array('isCreate' => true))
						</div>
						<div class="col-sm-12">
							@include('admin.common.inputStatusLang', array('isCreate' => true))
							@include('admin.common.inputContent', array('isCreate' => true))
							@include('admin.common.inputMeta', array('isCreate' => true))
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