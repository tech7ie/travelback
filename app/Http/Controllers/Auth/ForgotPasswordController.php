<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use mysql_xdevapi\Exception;

class ForgotPasswordController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail( Request $request ) {
        $this->validateEmail( $request );

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.

        $new_password = uniqid( 8 );


        $user = User::where( 'email', $request->email )
                    ->update( [ 'password' => Hash::make( $new_password ) ] );

        $to_email = $request->email;

        try {
            Mail::send( 'emails.new_password', [ 'password' => $new_password ], function ( $message ) use (
                $to_email
            ) {
                $message->to( $to_email )
                        ->subject( 'TripLine Request' );
            } );

            return true;
        } catch ( Exception $e ) {
            return $e->getMessage();
        }

        $response = $this->broker()->sendResetLink(
            $this->credentials( $request )
        );


        print_r( $response );
        die( Password::RESET_LINK_SENT );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse( $request, $response )
            : $this->sendResetLinkFailedResponse( $request, $response );
    }


    /**
     * Validate the email for the given request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateEmail( Request $request ) {
        $request->validate( [ 'email' => 'required|email' ] );
    }
}
