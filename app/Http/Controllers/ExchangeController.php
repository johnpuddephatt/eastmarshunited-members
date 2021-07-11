<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Message;
use App\Models\Proposal;
use App\Events\ExchangeCreated;
use App\Events\ExchangeApproved;
use App\Events\ExchangeCompleted;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Proposal $proposal)
    {
        $exchange = Exchange::create([
            'source_user_id' => \Auth::user()->id,
            'recipient_user_id' => $proposal->user->id,
            'value' => $proposal->hours,
            'proposal_id' => $proposal->id,
            'status' => 'pending'
        ]);

        if($request->message) {
            $message = Message::create([
                'content' => $request->message,
                'recipient_id' => $proposal->user->id,
                'sender_id' => \Auth::user()->id,
                'exchange_id' => $exchange->id,
                'proposal_id' => $proposal->id
            ]);
        }

        event(new ExchangeCreated($exchange, $message ?? null));


        return redirect()->route('proposal.show', ['proposal' => $proposal]);
    }


    public function approve(Request $request, Proposal $proposal, Exchange $exchange)
    {
        $exchange->status = 'approved';
        $exchange->save();

        if($request->message) {
            $message = Message::create([
                'content' => $request->message,
                'recipient_id' => $exchange->source_user->id,
                'sender_id' => \Auth::user()->id,
                'exchange_id' => $exchange->id,
                'proposal_id' => $proposal->id
            ]);
        }

        event(new ExchangeApproved($exchange, $message ?? null));

        return redirect()->route('proposal.show', ['proposal' => $proposal]);
    }


    public function complete(Request $request, Proposal $proposal, Exchange $exchange)
    {
        $exchange->status = 'complete';
        $exchange->save();

        $exchange_value = $request->hours ?? $proposal->hours;

        if ($proposal->type == 'ask') {
            $exchange->source_user->increment('credits', $exchange_value);
            $exchange->recipient_user->decrement('credits', $exchange_value);
        }
        else {
            $exchange->source_user->decrement('credits', $exchange_value);
            $exchange->recipient_user->increment('credits', $exchange_value);            
        }
        
        if($request->message) {
            $message = Message::create([
                'content' => $request->message,
                'recipient_id' => $exchange->source_user->id,
                'sender_id' => \Auth::user()->id,
                'exchange_id' => $exchange->id,
                'proposal_id' => $proposal->id
            ]);
        }

        event(new ExchangeCompleted($exchange, $message ?? null));

        return redirect()->route('proposal.show', ['proposal' => $proposal]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exchange  $exchange
     * @return \Illuminate\Http\Response
     */
    public function show(Exchange $exchange)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exchange  $exchange
     * @return \Illuminate\Http\Response
     */
    public function edit(Exchange $exchange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exchange  $exchange
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exchange $exchange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exchange  $exchange
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exchange $exchange)
    {
        //
    }
}
