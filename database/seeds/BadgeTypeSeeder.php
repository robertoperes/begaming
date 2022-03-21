<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Enuns\BadgeTypeEnum;

class BadgeTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('badge_type')->insertOrIgnore(
            [
                'id'          => BadgeTypeEnum::WELL_BEING,
                'icon'        => '/images/badges/type/bem-estar-classic.png',
                'description' => 'Bem estar',
                'active'      => true,
                'created_at'  => Carbon::now('UTC')
            ]);
        DB::table('badge_type')->insertOrIgnore(
            [
                'id'          => BadgeTypeEnum::EVOLUTION,
                'description' => 'Evolução',
                'icon'        => '/images/badges/type/cursos-palestras-classic.png',
                'active'      => true,
                'created_at'  => Carbon::now('UTC')
            ]);
        DB::table('badge_type')->insertOrIgnore(
            [
                'id'          => BadgeTypeEnum::ENGAGEMENT,
                'description' => 'Engajamento',
                'icon'        => '/images/badges/type/engajamento-classic.png',
                'active'      => true,
                'created_at'  => Carbon::now('UTC')
            ]);
        DB::table('badge_type')->insertOrIgnore(
            [
                'id'          => BadgeTypeEnum::COMPANY_TIME,
                'description' => 'Tempo de empresa',
                'icon'        => '/images/badges/type/tempo-empresa-classic.png',
                'active'      => true,
                'created_at'  => Carbon::now('UTC')
            ]);
        DB::table('badge_type')->insertOrIgnore(
            [
                'id'          => BadgeTypeEnum::ADMIRATION,
                'description' => 'Admiração',
                'icon'        => '/images/badges/type/admiracao-classic.png',
                'active'      => true,
                'created_at'  => Carbon::now('UTC')
            ]);
        DB::table('badge_type')->insertOrIgnore(
            [
                'id'          => BadgeTypeEnum::CULTURE,
                'description' => 'Cultura',
                'icon'        => '/images/badges/type/cultura-classic.png',
                'active'      => true,
                'created_at'  => Carbon::now('UTC')
            ]);
    }
}
