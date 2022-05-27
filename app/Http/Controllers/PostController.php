<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Models\Post;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{


    public function create(Request $request, $website)
    {

        $website = Website::where('slug', $website)->first();

        if ($website == null)
        {
            return ['sucess' => false, 'message' => "Website Not Found !"];
        }

        $validator = Validator::make($request->all(), Post::$rules);
        
        if ($validator->fails())
        {
            return response()->json([
              'errors' => $validator->errors(),
              'status' => Response::HTTP_BAD_REQUEST,
              'sucess' => false
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = [
            "website_id" => $website->id,
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ];
        $post = Post::create($data);

        foreach ($website->subscriptions as $sub)
        {
            dispatch(new SendEmail([
                'post' => $post,
                'to' => $sub->email
            ]));
        }

        return ['sucess' => true, 'message' => "Posted Sucessfully !"];
    }
}
