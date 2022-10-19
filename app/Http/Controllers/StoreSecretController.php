<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Spatie\Crypto\Rsa\PrivateKey;

class StoreSecretController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $privateKey = PrivateKey::fromString($user->private_key);

        $data = $request->only(['store', 'key', 'value']);

        $decryptedData = $privateKey->decrypt(base64_decode($data['value']));

        $encryptedData = $privateKey->encrypt($decryptedData);

        Redis::set("{$data['store']}:{$data['key']}", $encryptedData);
    }
}
