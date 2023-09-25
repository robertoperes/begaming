<?php

namespace App\Console\Commands;

use App\Enuns\BadgeTypeEnum;
use App\Enuns\UserPointBadgeStatusEnum;
use App\Services\TeamService;
use App\Services\UserBadgeService;
use App\Services\UserPointBadgeHistoryService;
use App\Services\UserPointBadgeService;
use App\Services\UserService;
use Carbon\Carbon;
use Carbon\Traits\Boundaries;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportUsersCommand extends Command
{

    protected $signature = 'import_users';
    protected $description = 'Importa usuários VivoGO';

    /* @var UserService */
    protected $userService;

    /* @var TeamService */
    protected $teamService;

    public function __construct()
    {
        $this->userService = app(UserService::class);
        $this->teamService = app(TeamService::class);
        parent::__construct();
    }

    public function handle()
    {

        $now = Carbon::now('America/Sao_Paulo');

        try {

            $client = new Client();
            $body = [
                'json' => [
                    'public_key' => 'CE1E585166638',
                    'private_key' => '7Ud7kNfHxkDPVx4UT8ZKiKi0HuS22Xxq'
                ]
            ];
            $request    = $client->post('https://lavivogo.before.com.br/api/vivogo/obter-token', $body);
            $token      = $request->getBody()->__toString();

            $headers = [
                'Auth' => $token
            ];

            $data = json_decode($client->get('https://lavivogo.before.com.br/api/before/usuarios?ativo=1', [
                'headers' => $headers
            ])->getBody()->__toString(), true);
            $users = $data['data'];

            $userIds = [];

            foreach ($users as $user){

                try {
                    $team = $this->teamService->findBy(['name' => $user['time']]);
                } catch (\Exception $exception) {
                    $team = $this->teamService->create([
                        'name'          => $user['time'],
                        'created_at'    => Carbon::now('UTC'),
                        'created_by'    => 1
                    ]);
                }

                try {
                    $localUser = $this->userService->findUserBy(['email' => $user['email']]);
                    $this->userService->update($localUser, [
                        'name'              => $user['nome'],
                        'admission_date'    => $user['data_adm'],
                        'team_id'           => $team->id,
                        'city_name'         => $user['cidade'],
                        'state_letter'      => $user['uf'],
                        'updated_at'        => Carbon::now('UTC')
                    ]);
                    $userIds[] = $localUser->id;

                } catch (\Exception $exception) {
                    $localUser = $this->userService->create([
                        'active'            => true,
                        'name'              => $user['nome'],
                        'email'             => $user['email'],
                        'admission_date'    => $user['data_adm'],
                        'city_name'         => $user['cidade'],
                        'state_letter'      => $user['uf'],
                        'team_id'           => $team->id,
                        'password'          => Hash::make(''),
                        'api_token'         => Str::random(60),
                        'created_at'        => Carbon::now('UTC')
                    ]);
                    $userIds[] = $localUser->id;
                }
            }

            $this->userService->inactiveOldUsers($userIds);

        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}