<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\Approved;

class UserApprovalController extends Controller
{
 public function approve(Request $request, User $user)
    {
        $user->update([
            'approved' => true
        ]);

        event(new Approved($user));

        return view('auth.activated', compact('user'));
    }   

    public function unapproved(Request $request)
    {
        return view('auth.unapproved');
    }   
}
