<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PendingPayment;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, $type)
    {
        return view('auth.register', compact('type'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'date_of_birth' => Rule::requiredIf($request->membership_type != 'organisation'),
        ]);

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_of_birth' => Carbon::parse($request->date_of_birth)->toDateTimeString(),
            'type' => $request->membership_type
        ]));

        event(new Registered($user));

        if($request->membership_type != 'organisation') {
            $user->approved = true;
            $user->save();
        }

        if($request->membership_type == 'member') {
            return redirect(route('register.payment'));
        }
        else {
            return redirect(route('register.complete'));
        }
    }

    /**
     * Display the registration complete view.
     *
     * @return \Illuminate\View\View
     */
    public function payment()
    {
        return view('auth.payment');
    }

    public function checkout(Request $request) {

        \Stripe\Stripe::setApiKey(config('services.stripe.secret_key'));

        try {
          $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $request->amount ?? 100,
            'currency' => 'gbp'
          ]);

          PendingPayment::create([
              'user_id' => Auth::user()->id,
              'payment_intent' => $paymentIntent->id
          ]);

          return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        }
        catch (Error $e) {
          return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the registration complete view.
     *
     * @return \Illuminate\View\View
     */
    public function complete()
    {
        return view('auth.complete');
    }


    public function paid(Request $request) {

        \Stripe\Stripe::setApiKey(config('services.stripe.secret_key'));

        try {
            $event = \Stripe\Event::constructFrom(
                $request->all()
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            abort(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
                $pendingPayment = PendingPayment::where('payment_intent', $event->data->object->id)->first();
                $pendingPayment->user()->update([
                    'is_member' => 1
                ]);
                $pendingPayment->delete();
            // ... handle other event types
            default:
                return response('LGTM!', 200);
        }

    }
}
