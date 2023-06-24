<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Passport\Token;
use Laravel\Sanctum\PersonalAccessToken;

class OauthController extends Controller
{
    public function authorization(Request $request)
    {
        $request->session()->put('state', $state = Str::random(128));
        $request->session()->put(
            'code_verifier', $code_verifier = Str::random(128)
        );

        $codeChallenge = strtr(rtrim(
            base64_encode(hash('sha256', $code_verifier, true))
            , '='), '+/', '-_');

        $query = http_build_query([
            'client_id'             => $request->id,
            'redirect_uri'          => url('/callback?id=').$request->id,
            'response_type'         => 'code',
            'scope'                 => '',
            'state'                 => $state,
            'code_challenge'        => $codeChallenge,
            'code_challenge_method' => 'S256',
            // 'prompt' => '', // "none", "consent", or "login"
        ]);

        return redirect(url('oauth/authorize?') . $query);
    }

    public function token(Request $request)
    {
        $state     = $request->session()->pull('state');

        $codeVerifier = $request->session()->pull('code_verifier');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class
        );

        $data = [
            'grant_type'    => 'authorization_code',
            'client_id'     => $request->id,
            'redirect_uri'  => url('/callback?id=').$request->id,
            'code_verifier' => $codeVerifier,
            'code'          => $request->code,
        ];

        $data            = Request::create(route('passport.token'), 'POST', $data);
        $response        = app('router')->prepareResponse($data, app()->handle($data));
        $responseMessage = $response->getContent();
        return json_decode($responseMessage);
    }

    public function getToken($id)
    {
        $tokens = Token::where('client_id', request()->clientID)->whereRevoked(0)->get();
        return Inertia::render('Backend/Client/Oauth/Tokens', ['tokens' => $tokens]);
    }

    public function revoke(Token $token): RedirectResponse
    {
        $token->revoke();
        return redirect()->back();
    }
}
