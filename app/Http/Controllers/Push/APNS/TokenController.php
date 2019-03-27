<?php

namespace App\Http\Controllers\Push\APNS;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use JWage\APNS\Certificate;
use JWage\APNS\Safari\PackageGenerator;

class TokenController extends Controller
{
    /**
     * A dummy endpoint used clientside
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response(null, 204);
    }

    /**
     * Store a APNS device token
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $version
     * @param  string  $deviceToken
     * @param  string  $websitePushID
     * @return Response
     */
    public function store(Request $request, $version, $deviceToken, $websitePushID)
    {
        $user = $this->getUser($request);
        $tokens = $user->apn_tokens ?: [];

        if (array_has($tokens, $deviceToken) === false) {
            array_push($tokens, $deviceToken);
            $user->update(['apn_tokens' => $tokens]);
        }

        // Apple doesn't like 204's it seems, so 200 it is
        return Response(null, 200);
    }

    /**
     * Delete a APNS device token
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $version
     * @param  string  $deviceToken
     * @param  string  $websitePushID
     * @return Response
     */
    public function destroy(Request $request, $version, $deviceToken, $websitePushID)
    {
        $user = $this->getuser($request);
        $tokens = $user->apn_tokens ?: [];

        if (array_has($tokens, $deviceToken) === true) {
            array_splice($tokens, array_search($deviceToken, $tokens), 1);
            $user->update(['apn_tokens' => $tokens]);
        }

        // Apple doesn't like 204's it seems, so 200 it is
        return Response(null, 200);
    }

    /**
     * Find a user using the request's Authorzation Header
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\User
     * @throws  \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    private function getuser(Request $request)
    {
        $userHash = preg_replace(
            '/^ApplePushNotifications (.+)/',
            '$1',
            $request->header('Authorization')
        );

        return User::whereRaw('SHA1(id) = ?', [$userHash])
            ->firstOrFail();
    }
}
