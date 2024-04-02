<?php

namespace App\Services;

use App\Token;
use Exception;
use Illuminate\Support\Facades\Http;

class GalaxPayConfigHelper{
    public static function GetGalaxPayServiceConfiguration()
    {
        return array(
            // 'galaxID' => '2976',
            // 'galaxHash' => 'XlE71qUbKn1o53UnXqG4I40fIiOpWqVfFf77N5Py',
            //  'URL' => 'https://api.galaxpay.com.br/v2'
            'galaxID' => '5473',
            'galaxHash' => '83Mw5u8988Qj6fZqS4Z8K7LzOo1j28S706R0BeFe',
            'URL' => 'https://api.sandbox.cel.cash/v2'
        );
    }

    public static function GetGalaxPayConfigurationWithSubaccountData($galaxID, $galaxHash)
    {
        return array(
            // 'galaxID' => '2976',
            // 'galaxHash' => 'XlE71qUbKn1o53UnXqG4I40fIiOpWqVfFf77N5Py',
            //  'URL' => 'https://api.galaxpay.com.br/v2'
            'galaxID' => $galaxID,
            'galaxHash' => $galaxHash,
            'URL' => 'https://api.sandbox.cel.cash/v2'
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

    public static function getTokenFromSubaccount($scopes, $galaxId, $galaxHash)
    {
        $configs = self::GetGalaxPayConfigurationWithSubaccountData($galaxId, $galaxHash);

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
