<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PushSubscription\CreateRequest;
use App\Http\Requests\Api\PushSubscription\DeleteRequest;
use App\Http\Requests\Api\PushSubscription\UpdateRequest;
use App\Http\Resources\PushSubscriptionResource;
use Illuminate\Http\Request;
use NotificationChannels\WebPush\PushSubscription;

class PushServiceController extends Controller
{
    /**
     * Store a newly created or update an existing PushSubscription in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $subscription = $request->user()
            ->updatePushSubscription(...array_values($request->validated()));

        return new PushSubscriptionResource($subscription);
    }

    /**
     * Remove the specified PushSubscription from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request)
    {
        $request->user()->deletePushSubscription($request->input('endpoint'));

        return response()->json(null);
    }
}
