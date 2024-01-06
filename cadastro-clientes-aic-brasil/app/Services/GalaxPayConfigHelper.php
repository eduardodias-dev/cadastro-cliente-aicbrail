<?php

namespace App\Services;

use App\Token;
use Exception;
use Illuminate\Support\Facades\Http;

class GalaxPayConfigHelper{
    public static function GetGalaxPayServiceConfiguration()
    {
        return array(
            'galaxID' => env('GALAX_ID'),
            'galaxHash' => env('GALAX_HASH'),
            'URL' => env('GALAX_URL')
        );
    }

    public static function getToken(string $scopes){
        $token = Token::orderByDesc('expires_in')->first();

        if($token != null){
            $now = strtotime('now');

            if($now > strtotime($token['expires_in']) || !str_contains($token['scope'], $scopes)){
                $token = self::requestTokenFromExternalService($scopes);
            }
        }else{
            $token = self::requestTokenFromExternalService($scopes);
        }
        return $token;
    }

    private static function requestTokenFromExternalService(string $scopes){
        $configs = self::GetGalaxPayServiceConfiguration();

        $request = Http::withBasicAuth($configs['galaxID'], $configs['galaxHash'])
                        ->post($configs['URL'].'/token',
                        [
                            "grant_type" => "authorization_code",
                            "scope"      => $scopes
                        ]);

        if($request->successful() == false){
            throw new Exception("Não foi possível recuperar o token\n". json_encode($request->json()["error"]["message"]));
        }
        $expires_in = intval($request['expires_in']);

        $token = new Token;
        $token['access_token'] = $request['access_token'];
        $token['token_type']   = $request['token_type'];
        $token['scope']        = $request['scope'];
        $token['expires_in']   = date('Y-m-d H:i:s', $expires_in+strtotime('now'));

        $token->save();

        return $token;
    }
}
