<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>always</changefreq>
        <priority>1</priority>
    </url>
    <?php 
        $gameTypes = CommonQuery::getAllWithStatus('game_types');
        $gameTags = CommonQuery::getAllWithStatus('game_tags');
        $games = CommonQuery::getAllWithStatus('games');
    ?>
    @if($gameTypes)
        @foreach($gameTypes as $value)
        <?php 
            if($value->parent_id > 0) {
                $parentSlug = CommonQuery::getFieldById('game_types', $value->parent_id, 'slug');
                $gameTypeUrl = CommonUrl::getUrl2($parentSlug, $value->slug);
            } else {
                $gameTypeUrl = CommonUrl::getUrl($value->slug);
            }
        ?>
        <url>
        	<loc>{{ $gameTypeUrl }}</loc>
    		<changefreq>weekly</changefreq>
    		<priority>0.8</priority>
        </url>
        @endforeach
    @endif
    @if($gameTags)
        @foreach($gameTags as $value)
        <url>
        	<loc>{{ CommonUrl::getUrlGameTag($value->slug) }}</loc>
    		<changefreq>weekly</changefreq>
    		<priority>0.8</priority>
        </url>
        @endforeach
    @endif
    @if($games)
        @foreach($games as $value)
    	    <url>
    	    	<loc>{{ CommonUrl::getUrl($value->slug) }}</loc>
    	    	<lastmod>{{ date('Y-m-d', strtotime($value->start_date)) }}</lastmod>
    			<changefreq>weekly</changefreq>
    			<priority>0.8</priority>
    	    </url>
    	@endforeach
    @endif
</urlset>