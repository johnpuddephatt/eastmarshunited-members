<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserProfileController extends Controller
{

    public function show() {
        return view('profile', [
            'categories' => \App\Models\Category::all()
        ]);
    }

    public function store(Request $request) {
        
        \Auth::user()->update($request->all());

        if(is_null(\Auth::user()->credits)) {
            \Auth::user()->update([
                'has_completed_profile' => true,
                'credits' => \Auth::user()->type == 'organisation' ? -1 : intval(env('INITIAL_CREDITS'))
            ]);
        }

        if($request->category) {
            \Auth::user()->categories()->sync(array_keys($request->category));
        }

        return redirect()->route('dashboard');
    }
}
