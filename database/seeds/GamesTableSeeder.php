<?php

use App\Models\GameTagRelation;
use App\Models\GameTypeRelation;
use App\Models\Game;
use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i=0;
        while($i < 100) {
            Game::create([
                'name' => 'Copernican Revolution',
                'slug' => 'copernican-revolution',
                'type_main_id' => 1,
                'seri' => 10,
                'related' => 1,
                'type' => 1,
                'url' => '',
                'summary' => 'Welcome to our famobilicious HTML 5 cross-device game catalog. Here you can find more than 300 non-exclusive and exclusive licensed HTML5 games',
                'description' => '<p>Welcome to our famobilicious HTML 5 cross-device game catalog. Here you can find more than 300 non-exclusive and exclusive licensed HTML5 games, reviewed, categorized and hand-picked for every taste. Feel free to browse through our games created by developers from all around the world. If you like New Games games, you should check out the other categories from our famobilicious game catalog. Do you need help? Why dont you check out our Help & Support category and see if your questions and problems can be solved.</p>',
                'image' => 'http://placehold.it/400x370&amp;text=Pegasi B',
                'meta_title' => 'Copernican Revolution',
                'meta_keyword' => 'Copernican Revolution',
                'meta_description' => 'Copernican Revolution',
                'start_date' => date('Y-m-d H:i:s'),
                'position' => 1,
                'status' => ACTIVE,
                'lang' => VI,
            ]);
            $i++;
            GameTypeRelation::insert([
                'game_id' => $i,
                'type_id' => 1,
            ]);
            GameTagRelation::insert([
                'game_id' => $i,
                'tag_id' => 1,
            ]);
        }
    }
}
