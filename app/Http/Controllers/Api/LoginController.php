<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = auth()->attempt($credentials)) {
            return response()->json([
                'success' => true,
                'message' => 'You have been logged in',
                'status' => 200,
                'result' => [
                    'token' => $token,
                    'data' =>auth('api')->user(),
                ],
            ]);
        }
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'Good bye'
        ]);
    }

    public function passwordReset(Request $request)
    {
        // dd($request->all());
        $user_email = User::where('email',$request->email)->first();
        // dd($user_email);
        $token=Str::random(40);
        if ($user_email) {
            $user_email->update([
                'reset_token'=>$token,
                'reset_token_expire_at'=> Carbon::now()->addMinute(2)
            ]);
            $link = route('new.password',$token);
            // dd($link);
            Mail::to($user_email->email)->send(new PasswordResetMail($link));
            return response()->json([
                'message'=>'Reset link has sent to your mail.',
                'reset_token'=>$token,
            ]);
        }
    }

    public function newPassword(Request $request)
    {
        $user_token = User::where('reset_token',$request->reset_token)->first();
        if($user_token){
            //check token expired or not
            if($user_token->reset_token_expire_at>=Carbon::now()){
               $user_token->update([
                  'password'=> bcrypt($request->password),
                   'reset_token'=>null
               ]);
               return response()->json([
                   'message'=>'Your password has updated.'
               ]);
            }else{
                return response()->json([
                    'message'=>'Token has expired. Try again.'
                ]);
            }

        }else
        {
           return response()->json([
               'message'=>'Invalid Token.'
           ]);
        }
    }
}
