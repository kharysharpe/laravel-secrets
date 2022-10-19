<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class DeleteSecretController extends Controller
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

        $data = $request->only(['key']);

        $hash = sha1($data['key'] + env('SECRETS_PEPPER'));

        $encryptedData = base64_encode(Redis::get($hash));

        return ['value' => $encryptedData];
    }
}
