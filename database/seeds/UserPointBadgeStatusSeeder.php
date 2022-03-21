<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserPointBadgeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_point_badge_status')->insertOrIgnore(
            [
                'id'          => 1,
                'description' => 'Aguardando',
                'active'      => true,
                'created_at' => Carbon::now('UTC')
            ]);
        DB::table('user_point_badge_status')->insertOrIgnore(
            [
                'id'          => 2,
                'description' => 'Aguardando aprovação',
                'active'      => true,
                'created_at' => Carbon::now('UTC')
            ]);
        DB::table('user_point_badge_status')->insertOrIgnore(
            [
                'id'          => 3,
                'description' => 'Aprovado',
                'active'      => true,
                'created_at' => Carbon::now('UTC')
            ]);
    }
}
