<header class="show-for-medium">
	<div class="row column">
		<a href="/" class="logo"><img src="/img/logo.png" alt="" /></a>
		{!! $topmenu !!}
	</div>
</header>
<div class="search">
	<div class="row column">
		<form action="{{ route('site.search') }}" method="GET" class="search-form">
			<div class="input-group">
				<input name="name" type="text" value="" class="input-group-field" id="searchtext" placeholder="Tìm kiếm">
				<div class="input-group-button">
					<a class="button" onclick="$('.search-form').submit()"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</a>
				</div>
			</div>
			<p>Hãy nhập tên game, hoặc 1 phần tên game bạn muốn tìm kiếm. Ví dụ: <a title="tai game skyrim" href="/tim-kiem?name=skyrim">skyrim</a>, <a title="tai game cod" href="/tim-kiem?name=call+of+duty">call of duty</a>, <a title="tai game ban ga" href="/tim-kiem?name=ban+ga">ban ga</a> ...</p>
        </form>
	</div>
</div>