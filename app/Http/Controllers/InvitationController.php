<?php

namespace App\Http\Controllers;
use App\Invitation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvitationRequest;

class InvitationController extends Controller
{
    public function index()
    {
        // $invitations = Invitation::where('registered_at', null)->orderBy('created_at', 'desc')->get();
        $invitations = Invitation::orderBy('created_at', 'desc')->get();
        $invitationsPending = Invitation::where('registered_at', null)->orderBy('created_at', 'desc')->get();

        return view('invitations', compact('invitations'))
            ->with('count',$invitationsPending->count());
    }

    // public function store(Request $request)
    public function store(StoreInvitationRequest $request)
    {
        $invitation = new Invitation($request->all());
        $invitation->generateInvitationToken();
        $invitation->save();

        $invitations = Invitation::orderBy('created_at', 'desc')->get();
        $invitationsPending = Invitation::where('registered_at', null)->orderBy('created_at', 'desc')->get();        

        return view('invitations', compact('invitations'))
            ->with('invitations',$invitations)
            ->with('count',$invitationsPending->count())            
            ->with('success', 'Invitation token successfully created.');
    }    
    
}
