<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Website;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function subscribe(Request $request, $website)
    {
        $data = $request->validate(Subscription::$rules);
        $website = Website::where('website_name', $website)->first();

        if ($website == null)
        {
            abort(404);
        }

        $subscription = Subscription::where('email', $data['email'])->first();

        if (!$subscription == null && $subscription->website->website_name == $website)
        {
            return ['message' => "Already Subscribed !", 'type' => "failed"];
        }

        $toInsert = [
            "website_id" => $website->id,
            "email" => $data['email']
        ];

        Subscription::create($toInsert);

        return ['message' => "Subscribed to website sucessfully !", 'type' => "sucess"];
    }
}
