<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Jobs\PushNotificationJob;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->serverKey = config('app.firebase_server_key');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $users = \App\User::all();

        PushNotificationJob::dispatch('sendBatchNotification', [
            'cgBWgkQA1dg:APA91bHQBHYz9bgP5ofXYrCXP4eIlAoGOipILkzjwt35SCp2eGR5PuOifcKXiVRDMvzfacdceMlQjxC65ojpTNnyfxdMMP7nfKCmiX7LLeKJ--2YMdsrs0aIlh3lBqRoeIz_yLz32-li',
            [
                'topicName' => 'birthday',
                'title' => 'Chúc mứng sinh nhật',
                'body' => 'Chúc bạn sinh nhật vui vẻ',
                'image' => 'https://picsum.photos/536/354',
            ],
        ]);

        return view('home')->with(['user_id' => $user->id, 'users' => $users]);
    }


}
