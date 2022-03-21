<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Enuns\BadgeClassificationEnum;

class BadgeClassificationSeeder extends Seeder
{

    public function run()
    {

        DB::table('badge_classification')->insertOrIgnore(
            [
                'id'          => BadgeClassificationEnum::CLASSIC,
                'description' => 'Classic',
                'color'       => '',
                'active'      => true,
                'created_at'  => Carbon::now('UTC')
            ]);
        DB::table('badge_classification')->insertOrIgnore(
            [
                'id'          => BadgeClassificationEnum::SILVER,
                'description' => 'Silver',
                'color'       => '#AAA9AD',
                'active'      => true,
                'created_at'  => Carbon::now('UTC')
            ]);
        DB::table('badge_classification')->insertOrIgnore(
            [
                'id'          => BadgeClassificationEnum::GOLD,
                'description' => 'Gold',
                'color'       => '#FFDF00',
                'active'      => true,
                'created_at'  => Carbon::now('UTC')
            ]);
        DB::table('badge_classification')->insertOrIgnore(
            [
                'id'          => BadgeClassificationEnum::BLACK,
                'description' => 'Black',
                'color'       => '#000000',
                'active'      => true,
                'created_at'  => Carbon::now('UTC')
            ]);

    }
}
