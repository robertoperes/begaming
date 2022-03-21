<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Enuns\BadgeTypeEnum;
use App\Enuns\BadgeClassificationEnum;

class BadgeSeeder extends Seeder
{
    public function run()
    {
        $id = 1;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Bem estar',
                'description'             => '',
                'value'                   => 100,
                'icon'                    => '/images/badges/classification/bem-estar-classic.png',
                'badge_type_id'           => BadgeTypeEnum::WELL_BEING,
                'badge_classification_id' => BadgeClassificationEnum::CLASSIC,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Bem estar',
                'description'             => '',
                'value'                   => 160,
                'icon'                    => '/images/badges/classification/bem-estar-silver.png',
                'badge_type_id'           => BadgeTypeEnum::WELL_BEING,
                'badge_classification_id' => BadgeClassificationEnum::SILVER,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Bem estar',
                'description'             => '',
                'value'                   => 220,
                'icon'                    => '/images/badges/classification/bem-estar-gold.png',
                'badge_type_id'           => BadgeTypeEnum::WELL_BEING,
                'badge_classification_id' => BadgeClassificationEnum::GOLD,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Bem estar',
                'description'             => '',
                'value'                   => 280,
                'icon'                    => '/images/badges/classification/bem-estar-black.png',
                'badge_type_id'           => BadgeTypeEnum::WELL_BEING,
                'badge_classification_id' => BadgeClassificationEnum::BLACK,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Evolução',
                'description'             => '',
                'value'                   => 180,
                'icon'                    => '/images/badges/classification/cursos-palestras-classic.png',
                'badge_type_id'           => BadgeTypeEnum::EVOLUTION,
                'badge_classification_id' => BadgeClassificationEnum::CLASSIC,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);

        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Evolução',
                'description'             => '',
                'value'                   => 350,
                'icon'                    => '/images/badges/classification/cursos-palestras-silver.png',
                'badge_type_id'           => BadgeTypeEnum::EVOLUTION,
                'badge_classification_id' => BadgeClassificationEnum::SILVER,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Evolução',
                'description'             => '',
                'value'                   => 520,
                'icon'                    => '/images/badges/classification/cursos-palestras-gold.png',
                'badge_type_id'           => BadgeTypeEnum::EVOLUTION,
                'badge_classification_id' => BadgeClassificationEnum::GOLD,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Evolução',
                'description'             => '',
                'value'                   => 690,
                'icon'                    => '/images/badges/classification/cursos-palestras-black.png',
                'badge_type_id'           => BadgeTypeEnum::EVOLUTION,
                'badge_classification_id' => BadgeClassificationEnum::BLACK,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Engajamento',
                'description'             => '',
                'value'                   => 215,
                'icon'                    => '/images/badges/classification/engajamento-classic.png',
                'badge_type_id'           => BadgeTypeEnum::ENGAGEMENT,
                'badge_classification_id' => BadgeClassificationEnum::CLASSIC,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Engajamento',
                'description'             => '',
                'value'                   => 391,
                'icon'                    => '/images/badges/classification/engajamento-silver.png',
                'badge_type_id'           => BadgeTypeEnum::ENGAGEMENT,
                'badge_classification_id' => BadgeClassificationEnum::SILVER,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Engajamento',
                'description'             => '',
                'value'                   => 567,
                'icon'                    => '/images/badges/classification/engajamento-gold.png',
                'badge_type_id'           => BadgeTypeEnum::ENGAGEMENT,
                'badge_classification_id' => BadgeClassificationEnum::GOLD,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Engajamento',
                'description'             => '',
                'value'                   => 745,
                'icon'                    => '/images/badges/classification/engajamento-black.png',
                'badge_type_id'           => BadgeTypeEnum::ENGAGEMENT,
                'badge_classification_id' => BadgeClassificationEnum::BLACK,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Tempo de empresa',
                'description'             => '',
                'value'                   => 4,
                'icon'                    => '/images/badges/classification/tempo-empresa-classic.png',
                'badge_type_id'           => BadgeTypeEnum::COMPANY_TIME,
                'badge_classification_id' => BadgeClassificationEnum::CLASSIC,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Tempo de empresa',
                'description'             => '',
                'value'                   => 8,
                'icon'                    => '/images/badges/classification/tempo-empresa-silver.png',
                'badge_type_id'           => BadgeTypeEnum::COMPANY_TIME,
                'badge_classification_id' => BadgeClassificationEnum::SILVER,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Tempo de empresa',
                'description'             => '',
                'value'                   => 12,
                'icon'                    => '/images/badges/classification/tempo-empresa-gold.png',
                'badge_type_id'           => BadgeTypeEnum::COMPANY_TIME,
                'badge_classification_id' => BadgeClassificationEnum::GOLD,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Tempo de empresa',
                'description'             => '',
                'value'                   => 16,
                'icon'                    => '/images/badges/classification/tempo-empresa-black.png',
                'badge_type_id'           => BadgeTypeEnum::COMPANY_TIME,
                'badge_classification_id' => BadgeClassificationEnum::BLACK,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Admiração',
                'description'             => '',
                'value'                   => 4,
                'icon'                    => '/images/badges/classification/admiracao-classic.png',
                'badge_type_id'           => BadgeTypeEnum::ADMIRATION,
                'badge_classification_id' => BadgeClassificationEnum::CLASSIC,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Admiração',
                'description'             => '',
                'value'                   => 6,
                'icon'                    => '/images/badges/classification/admiracao-silver.png',
                'badge_type_id'           => BadgeTypeEnum::ADMIRATION,
                'badge_classification_id' => BadgeClassificationEnum::SILVER,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Admiração',
                'description'             => '',
                'value'                   => 8,
                'icon'                    => '/images/badges/classification/admiracao-gold.png',
                'badge_type_id'           => BadgeTypeEnum::ADMIRATION,
                'badge_classification_id' => BadgeClassificationEnum::GOLD,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Admiração',
                'description'             => '',
                'value'                   => 10,
                'icon'                    => '/images/badges/classification/admiracao-black.png',
                'badge_type_id'           => BadgeTypeEnum::ADMIRATION,
                'badge_classification_id' => BadgeClassificationEnum::BLACK,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Cultura',
                'description'             => '',
                'value'                   => 4,
                'icon'                    => '/images/badges/classification/cultura-classic.png',
                'badge_type_id'           => BadgeTypeEnum::CULTURE,
                'badge_classification_id' => BadgeClassificationEnum::CLASSIC,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Cultura',
                'description'             => '',
                'value'                   => 8,
                'icon'                    => '/images/badges/classification/cultura-silver.png',
                'badge_type_id'           => BadgeTypeEnum::CULTURE,
                'badge_classification_id' => BadgeClassificationEnum::SILVER,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Cultura',
                'description'             => '',
                'value'                   => 12,
                'icon'                    => '/images/badges/classification/cultura-gold.png',
                'badge_type_id'           => BadgeTypeEnum::CULTURE,
                'badge_classification_id' => BadgeClassificationEnum::GOLD,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
        $id++;
        DB::table('badge')->insertOrIgnore(
            [
                'id'                      => $id,
                'name'                    => 'Cultura',
                'description'             => '',
                'value'                   => 16,
                'icon'                    => '/images/badges/classification/cultura-black.png',
                'badge_type_id'           => BadgeTypeEnum::CULTURE,
                'badge_classification_id' => BadgeClassificationEnum::BLACK,
                'active'                  => true,
                'created_at'              => Carbon::now('UTC')
            ]);
    }
}
