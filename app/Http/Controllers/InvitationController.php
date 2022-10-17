<?php

namespace App\Http\Controllers;
use App\Invitation;

class InvitationController extends Controller
{
    public function index()
    {
        // $invitations = Invitation::where('registered_at', null)->orderBy('created_at', 'desc')->get();
        $invitations = Invitation::orderBy('created_at', 'desc')->get();
        return view('invitations', compact('invitations'));
    }

    // public function store(StoreInvitationRequest $request)
    // {
    //     $invitation = new Invitation($request->all());
    //     $invitation->generateInvitationToken();
    //     $invitation->save();
    
    //     return redirect()->route('invitations')
    //         ->with('success', 'Invitation token successfully created.');
    // }    
    
}
