<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            BadgeClassificationSeeder::class,
            BadgeTypeSeeder::class,
            UserPointBadgeStatusSeeder::class,
            BadgeSeeder::class
        ]);
    }
}
