<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\ResourceCollectionAbstract;

class RankingUsersPointsBadgesResourceCollection extends ResourceCollectionAbstract
{

    public function toArray($request)
    {
        $data = [];

        $uniqueBadgeType = [];

        foreach ($this->collection as $item) {

            if(empty($item->total) || (((int)$item->total) === 0) || $item->has_user_badge == 1) {
                continue;
            }

            if(array_key_exists($item->user_id,$uniqueBadgeType) &&
                array_key_exists($item->badge_type_id,$uniqueBadgeType[$item->user_id])
            ){
                continue;
            }

            $uniqueBadgeType[$item->user_id][$item->badge_type_id] = true;

            $badge_id                                 = $item->badge_id;
            $data[$badge_id]['id']                    = $badge_id;
            $data[$badge_id]['name']                  = $item->badge_name;
            $data[$badge_id]['type']                  = $item->badge_type_description;
            $data[$badge_id]['classification']        = [
                'id'          => $item->badge_classification_id,
                'description' => $item->badge_classification_description
            ];
            $data[$badge_id]['icon']                  = $item->badge_icon;
            $data[$badge_id]['value']                 =
                $item->value;
            $data[$badge_id]['users'][$item->user_id] = [
                'id'             => $item->user_id,
                'name'           => $item->user_name,
                'google_avatar'  => $item->user_google_avatar,
                'total'          => (int)$item->total,
                'admission_date' => $item->admission_date,
                'team_name'      => $item->team_name,
            ];
        }

        foreach ($data as &$item) {
            if (empty($item['users'])) {
                continue;
            }
            array_multisort(
                array_column($item['users'], 'total'), SORT_DESC,
                array_column($item['users'], 'admission_date'), SORT_ASC,
                $item['users']);
        }

        return [
            'data' => $data,
        ];
    }

}