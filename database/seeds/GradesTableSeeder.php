<?php

use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')->insert([
            [
                'name' => 'Cycle1 (1-5)',
                'slug' => str_slug('Cycle1 (1-5)')
            ],
            [
                'name' => 'Cycle2 (6-9)',
                'slug' => str_slug('Cycle2 (6-9)')
            ],
            [
                'name' => 'Cycle3 (10-12)',
                'slug' => str_slug('Cycle3 (10-12)')
            ],
            [
                'name' => 'University',
                'slug' => str_slug('University')
            ],
        ]);
    }
}
