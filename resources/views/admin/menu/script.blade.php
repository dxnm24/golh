<script>
	function callupdate()
	{
		var id = $('input:checkbox.id').map(function () {
		  	return this.value;
		}).get();
		var position = $('input[name^="position"]').map(function () {
		  	return this.value;
		}).get();
		$.ajax(
		{
			type: 'post',
			url: '{{ url("admin/menu/callupdate") }}',
			data: {
				'id': id,
				'position': position,
				'_token': '{{ csrf_token() }}'
			},
			beforeSend: function() {
	            $('#loadMsg').html('Updating...');
	        },
			success: function(data)
			{
				if(data) {
					window.location.reload();
				}
			}
		});
		// window.location.reload();
	}
</script>