<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Notifications\PushJobs;
use App\User;
use Auth;
use Notification;
use App\Job;

class PushController extends Controller
{
    public function __construct(){
      $this->middleware('auth');
    }
    /**
     * Store the PushSubscription.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);
        
        return response()->json(['success' => true],200);
    }

	/**
	 * Testing Push Notifications w/ Android
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function push(){
		$job = Job::where("status", "=", "")->orderBy("id", "DESC")->first();

		Notification::send(User::all(),new PushJobs([
			"job_id"=>$job->id,
			"title"=>$job->post_title,
			"body" => $job->post_body_plain,
			"icon" => "https://codebuilder.us/images/mandala4_75.png"
		]));
	    return redirect()->back();
	}

}