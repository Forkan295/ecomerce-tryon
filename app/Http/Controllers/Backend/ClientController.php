<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Laravel\Passport\ClientRepository;

class ClientController extends Controller
{
    public function index()
    {
        $user = auth('web')->user();
//        if ($userId = request()->user) {
//            $user = User::with('clients')->whereId($userId)->first();
//        }

        $clients = $user->clients;

        return Inertia::render('Backend/Client/Oauth/Index', ['user' => $user, 'clients' => $clients]);
    }

    public function create()
    {
        return Inertia::render('Backend/Client/Oauth/Create', ['userId' => auth()->user()->id]);
    }

    public function store(Request $request)
    {
        $redirect       = null;
        $provider       = null;
        $personalAccess = null;
        $password       = null;
        $confidential   = null;
        $this->validate($request, [
            'client_type' => 'required',
        ]);
        switch ($request->client_type) {
            case 'pkce':
                $request->validate([
                    'name' => 'required|max:255',
//                    'redirect' => 'required|url',
                ]);
                $personalAccess = false;
                $password       = false;
                $confidential   = false;
                break;
            case 'password':
                $request->validate([
                    'name' => 'required|max:255',
                ]);
                $provider       = $request->provider;
                $personalAccess = false;
                $password       = true;
                $confidential   = true;
                break;
        }


        $client = (new ClientRepository)->create(auth('web')->user()?->id ?? request()->user, $request->name, url('/'), $provider, $personalAccess, $password, $confidential);

        if ($request->client_type == 'pkce') {
            $client->update(['redirect' => url('/callback?id=') . $client->id]);
        }

        return redirect()->route('backend.client.index', auth('web')->user()->tenant->domain)->with('success', 'Client succssfully created!');
    }

    public function getClients()
    {
        $clients = DB::table('oauth_clients')->get();

        return view('client.show', compact('clients'));
    }

    public function destroy($tenant, $id)
    {
        DB::table('oauth_clients')->where('id', $id)->delete();

        return redirect()->back();
    }

    public function getSecret($tenant, $id)
    {
        $clientRepository = new ClientRepository();
        $client           = $clientRepository->find($id); // Replace $clientId with the actual client ID

        return $client->secret;


    }
}
