<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Illuminate\Http\Request;

class FirebaseEmailVerificationController extends Controller
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function sendVerificationLink(Request $request)
    {
        $user = $request->user();

        $link = $this->auth->sendEmailVerificationLink($user->email, [
            'continueUrl' => config('app.url').'/email/verify/{id}/{hash}',
        ]);

        // You can send the link via email or redirect the user to a page with the link
        // Example email sending:
        // mail($user->email, 'Email Verification', $link);

        return response()->json(['message' => 'Verification link sent']);
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $email = $request->query('email');

        // Get the Firebase credentials file path
        $credentialsFile = config('firebase.credentials.file');

        // Get the Firebase project ID
        $projectId = config('firebase.project_id');

        // Initialize the Firebase SDK with your credentials file and project ID
        $firebase = (new Factory)
            ->withServiceAccount($credentialsFile)
            ->withProjectId($projectId)
            ->create();

        // Get the Auth instance from the Firebase SDK
        $auth = $firebase->getAuth();

        // Verify the email using Firebase SDK
        $auth->verifyEmail($email, $id, $hash);

        // Redirect the user to the email verification view
        return view('email-verification');
    }
}
