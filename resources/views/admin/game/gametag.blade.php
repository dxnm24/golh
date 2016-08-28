@if(isset($isCreate))
<?php 
	$dataTag = CommonQuery::getArrayWithStatus('game_tags');
?>
<div class="box-body table-responsive">
	<h4>Game Tags</h4>
	<div class="overflow-box">
		@if($dataTag)
			{!! Form::select('tag_id[]', $dataTag, old('tag_id'), array('class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => 'Select a Tag', 'style' => 'width: 100%;')) !!}
		@else
			<i>Chưa có tag nào được kích hoạt</i>
		@endif
	</div>
</div>
@elseif(isset($isEdit))
<?php 
	$dataTag = CommonQuery::getArrayWithStatus('game_tags');
	$issetGameTag = CommonGame::issetGameTag($data->id);
?>
<div class="box-body table-responsive">
	<h4>Game Tags</h4>
	<div class="overflow-box">
		@if($dataTag)
			{!! Form::select('tag_id[]', $dataTag, $issetGameTag, array('class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => 'Select a Tag', 'style' => 'width: 100%;')) !!}
		@else
			<i>Chưa có tag nào được kích hoạt</i>
		@endif
	</div>
</div>
@endif