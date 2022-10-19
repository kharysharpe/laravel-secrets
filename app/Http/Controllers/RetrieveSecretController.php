<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class RetrieveSecretController extends Controller
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

        $data = $request->only(['store', 'key']);

        $encryptedData = base64_encode(Redis::get("{$data['store']}:{$data['key']}"));

        return ['value' => $encryptedData];
    }
}
