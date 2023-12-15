<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class UserAuthService
{
    public function handle($validatedData)
    {
        $params = $validatedData;
        $sig = $validatedData['sig'];
        ksort($params);
        unset($params['sig']);
        $secretKey = Config::get('secrets.secret_key', 'default_value_if_not_set');
        $string = '';
        foreach ($params as $key => $value) {
            $string .= $key . '=' . $value;
        }
        $signature = mb_strtolower(md5($string . $secretKey), 'UTF-8');

        if ($signature !== $sig) {
            return [
                'error' => 'Signature error',
                'error_key' => 'signature_error',
            ];
        }

        $user = DB::table('users')->where('id', $validatedData['id'])->first();
        if (!$user) {
            $user = DB::table('users')->insertGetId([
                'id' => $validatedData['id'],
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'country' => $validatedData['country'],
                'city' => $validatedData['city'],
            ]);
        } else {
            DB::table('users')->where('id', $user->id)->update([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'country' => $validatedData['country'],
                'city' => $validatedData['city'],
            ]);
        }

        DB::table('users_sessions')->updateOrInsert(
            ['user_id' => $user->id],
            ['access_token' => $validatedData['access_token']]
        );

        return [
            'access_token' => $validatedData['access_token'],
            'user_info' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'city' => $user->city,
                'country' => $user->country,
            ],
            'error' => '',
            'error_key' => '',
        ];
    }
}

