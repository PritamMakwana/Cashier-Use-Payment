<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Stripe;

// use Stripe\Error\Card;
// use Stripe;;

class PlanController extends Controller
{
    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    public function index()
    {
        $plans = Plan::get();

        return view("plans", compact("plans"));
    }

    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    public function show(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();

        return view("subscription", compact("plan", "intent"));
    }
    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    public function subscription(Request $request)
    {

        // $stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // dd($stripe);




        $plan = Plan::find($request->plan);

        // dd($request);

        $subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)
                        ->create($request->token);

        return view("subscription_success");
    }
}
