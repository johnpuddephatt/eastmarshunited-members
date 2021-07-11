<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $types = [
            [ 'value' => 'ask',
              'title' => 'Ask',
              'description' => 'Ask people to do something for you'
            ],
            [
              'value' => 'offer',
              'title' => 'Offer',
              'description' => 'Offer to do something for other people'
            ],
            // [
            //     'value' => 'suggest',
            //     'title' => 'Suggest',
            //     'description' => 'Find people to do something for the community with you'
            // ]
        ];

    public function index()
    {
        $proposals = Proposal::with('categories')->get();
        return view('dashboard', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('proposal.form', ['categories' => $categories, 'types' => $this->types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Proposal $proposal
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $proposal = Proposal::create(
            array_merge([
            'user_id' => \Auth::user()->id
        ], $request->all()));

        $proposal->categories()->sync(explode(',',$request->categories));

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proposal $proposal
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal)
    {
        return view('proposal.show', ['proposal' => $proposal]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proposal $proposal
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal)
    {
        $categories = Category::all();
        $proposal->categories = $proposal
            ->categories()
            ->allRelatedIds()
            ->toArray();
        return view('proposal.form', ['types' => $this->types, 'proposal' => $proposal, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal)
    {
        $proposal->update(
            $request->all()
        );

        $proposal->categories()->sync(explode(',',$request->categories));

        return redirect()->route('dashboard');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposal $proposal)
    {
        //
    }
}
