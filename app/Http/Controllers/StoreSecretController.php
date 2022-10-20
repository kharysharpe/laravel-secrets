<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

        $data = $request->only(['key', 'value']);

        $hash = sha1($data['key'] . env('SECRETS_PEPPER'));

        $decryptedData = $privateKey->decrypt(base64_decode($data['value']));

        $encryptedData = $privateKey->encrypt($decryptedData);

        Cache::put($hash, $encryptedData);
    }
}
