<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RetrieveSecretController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $key)
    {

        $hash = sha1($key . env('SECRETS_PEPPER'));

        $encryptedData = base64_encode(Cache::get($hash));

        return ['value' => $encryptedData];
    }
}
