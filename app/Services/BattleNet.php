<?php
namespace App\Services;

//TODO: ability to change API region
use Xklusive\BattlenetApi\BattlenetHttpClient;
use GuzzleHttp\Client;
use App\User;
use App\Models\Character;

/**
 * @author Jerome Bordallo <bubbam2006@gmail.com>
 * 
 * my own for Battle.Net API. Uses Xklusive's Battle.Net API client
 */
class BattleNet extends BattlenetHttpClient
{

    /**
     * @var string
     */
    protected $cacheKey = 'jerome.battlenetapi.cache';


    /**
     * Game name for url prefix.
     *
     * @var string
     */
    protected $gameParam = ''; // make this unneeded in BattlenetHttpClient

    /**
     * Get achievement information by id.
     *
     * This provides data about an individual achievement
     *
     * @param string $accessToken current user's access token (via OAuth2)
     *
     * @return Illuminate\Support\Collection api response
     */
    public function getCurrentUser($accessToken)
    {
        $client = new Client([
            'base_uri' => 'us.battle.net',
        ]);

        $options = [
            'form_params' => [
                'token' => $accessToken,
                // 'client_id' => config('battlenet-api.client_id'),
                // 'client_secret' => config('battlenet-api.client_secret'),
                // 'redirect_uri' => config('battlenet-api.redirect_url'),
            ],
        ];

        $response = $client->request('POST', 'https://'.config('battlenet-api.region') . '.battle.net/oauth/check_token', $options);
        $response = json_decode($response->getBody()->getContents(), true);
        var_dump($response);

        $options = [
            'query' => [
                'access_token' => $accessToken,
                'client_id' => config('battlenet-api.client_id'),
                'client_secret' => config('battlenet-api.client_secret'),
                'redirect_uri' => config('battlenet-api.redirect_url'),
            ],
        ];
        $response = $client->request('GET', 'https://'.config('battlenet-api.region') . '.battle.net/wow/user/characters', $options);
        $response = json_decode($response->getBody()->getContents(), true);
        var_dump($response);

exit;

        $options = [
            'query' => ['access_token' => $accessToken],
        ];

        $request = '/profile/user/wow/characters';

        $options = [
            'query' => ['token' => $accessToken],
        ];

        return $this->cache($request, $options, __FUNCTION__);
    }

    /**
     * 
     * @param string $accessToken access token
     */
    public function updateCharacters($accessToken, $user_id, $region) {

        $characters = User::find($user_id)->characters()->get();
        
        $client = new Client([
            'base_uri' => 'us.battle.net',
        ]);

        $options = [
            'query' => [
                'access_token' => $accessToken,
            ],
        ];
        if ($region === 'cn') {
            // untested. Need cn account, and to know API endpoint for cn.
            $response = $client->request('GET', 'https://' . $region . '.api.battle.net/wow/user/characters', $options);
        } else {
            $response = $client->request('GET', 'https://' . $region . '.api.blizzard.com/wow/user/characters', $options);
        }

        $data = json_decode($response->getBody()->getContents(), true);

        $added = 0;
        foreach ($data['characters'] as $d) {
            $found = FALSE;
            foreach($characters as $c) {                
                if ($c->name === $d['name'] && $c->realm === $d['realm']) {
                    $found = TRUE;
                    break;
                }
            }
            if (!$found) {
                $char = new Character();
                $char->name = $d['name'];
                $char->realm = $d['realm'];
                $char->user_id = $user_id;
                $char->race = $d['race'];
                $char->class = $d['class'];
                $char->level = $d['level'];
                $char->region = $region;
                $char->save();
                $added++;
            }
        }
        
        return $added;
    }
}
