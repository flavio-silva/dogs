<?php

namespace App\Http\Controllers;

use App\Mail\PasswordRecovery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ForgotPasswordController extends Controller
{
    public function email(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', Rule::exists('users')]
        ]);

        $token = Str::random(8);

        DB::table('password_reset_tokens')
            ->updateOrInsert([
                'email' => $request->input('email'),
                'token' => $token,
            ]);

        Mail::to($request->input('email'))
            ->send(new PasswordRecovery($token));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', Rule::exists('users')],
            'token' => ['required', 'string'],
            'password' => ['required', 'min:8', 'max:40'],
        ]);

        $resetToken = DB::table('password_reset_tokens')
            ->whereEmail($request->input('email'))
            ->whereToken($request->input('token'))
            ->first();

            if ($resetToken == null) {
                return response([
                    'message' => 'Invalid email or token',
                ], HttpFoundationResponse::HTTP_BAD_REQUEST);
            }

        User::firstWhere('email', $request->input('email'))
            ?->update(['password' => $request->input('password')]);

            return response()->noContent();

    }
}
