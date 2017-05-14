<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invite;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    public function send(Request $request) {

        if (Auth::user()->role == 1) {
            try {
                $this->validate($request, ['email' => 'required|email']);
                $email = $request->get('email');
                $invite = new Invite(['email' => $email]);
                $invite->save();
                $invite->sendInvitation();

                $resp = array(
                    'status' => 'ok'
                );
            } catch (\Exception $e) {
                $resp = array(
                    'status' => $e->getMessage()
                );
            }

        } else {


            $resp = array(
                'status' => 'Access denied'
            );
        }


        return Response()->json($resp);
    }

    public function invitesonly() {
        return view('invitesonly');
    }
}
