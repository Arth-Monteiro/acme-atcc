<?php

namespace App\Http\Controllers;

//https://github.com/firebase/php-jwt
use Firebase\JWT\JWT;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;


class DashboardsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role.permission']);
    }

    public function index(): Renderable
    {
        $metabase_uri = config('app.metabase_uri');

        $iframe_uri = $metabase_uri . '/public/dashboard/ab0ff398-8d52-48e0-9f81-038e9356708b';
        if (!!($company_id = Auth::user()->company_id)) {

            $metabase_token = config('app.metabase_token');

            $payload = [
                'resource' => ['dashboard' => 1],
                'params' => ['empresa' => $company_id],
                'exp' => time() + (60 * 2) // 20 minutes
            ];

            $token = JWT::encode($payload, $metabase_token, 'HS256');
            $iframe_uri = $metabase_uri . '/embed/dashboard/' . $token . '#bordered=true&titled=false';
        }

        return view('dashboards.index', compact('iframe_uri'));
    }

}
