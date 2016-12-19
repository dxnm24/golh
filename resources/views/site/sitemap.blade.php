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
                $gameTypeUrl = url($parentSlug.'/'.$value->slug);
            } else {
                $gameTypeUrl = url($value->slug);
            }
        ?>
        <url>
        	<loc>{{ $gameTypeUrl }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
    		<changefreq>weekly</changefreq>
    		<priority>0.8</priority>
        </url>
        @endforeach
    @endif
    @if($gameTags)
        @foreach($gameTags as $value)
        <url>
        	<loc>{{ url('tag/'.$value->slug) }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
    		<changefreq>weekly</changefreq>
    		<priority>0.8</priority>
        </url>
        @endforeach
    @endif
    @if($games)
        @foreach($games as $value)
    	    <url>
    	    	<loc>{{ url($value->slug) }}</loc>
    	    	<lastmod>{{ date('Y-m-d', strtotime($value->updated_at)) }}</lastmod>
    			<changefreq>weekly</changefreq>
    			<priority>0.8</priority>
    	    </url>
    	@endforeach
    @endif
</urlset>