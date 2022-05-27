<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Website;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class SubscriptionController extends Controller
{

    public function subscribe(Request $request, $website)
    {
        $data = $request->input();
        $validator = Validator::make($data, Subscription::$rules);

        if ($validator->fails())
        {
            return response()->json([
              'errors' => $validator->errors(),
              'status' => Response::HTTP_BAD_REQUEST,
              'sucess' => false
            ], Response::HTTP_BAD_REQUEST);
        }
        
        $website = Website::where('slug', $website)->first();

        if ($website == null)
        {
            return ['sucess' => false, 'message' => "Website Not Found !"];
        }

        $subscription = Subscription::where('email', $data['email'])->first();

        if (!$subscription == null && $subscription->website->website_name == $website)
        {
            return ['message' => "Already Subscribed !", 'sucess' => false];
        }

        $toInsert = [
            "website_id" => $website->id,
            "email" => $data['email']
        ];

        Subscription::create($toInsert);

        return ['message' => "Subscribed to website sucessfully !", 'sucess' => true];
    }
}
