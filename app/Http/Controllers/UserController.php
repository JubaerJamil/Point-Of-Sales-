<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\View\View;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function RegistrationPage():View{
        return view('pages.auth.registration-page');
    }

    function LoginPage():View{
        return view('pages.auth.login-page');
    }

    function EmailOTPpage(){
        return view('pages.auth.send-otp-page');
    }

    function VerifyOTPpage(){
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage(){
        return view('pages.auth.reset-password-page');
    }

    function ProfilePage(){
        return view('pages.dashboard.profile-page');
    }


    function userregistration(Request $request){
        Try{
                User::create($request->input());
            return response()->json([
                "status" => "success",
                "message" => "Registrations successfully"
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                "status" => "Faild",
                "message" => "Registrations Failed"
            ],200);
            // return $e;
        };
    }

    function userlogin(Request $request){
        $response = User::where('email', '=', $request->input('email'))
                        ->where('password', '=', $request->input('password'))
                        ->select('id')->first();

        if ($response !== null){
            $token = JWTToken::createtoken($request->input('email'),$response->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => $token
                ],200)->cookie('token', $token, 60*24*30);
        }
        else{
        return response()->json([
            'status' => 'faild',
            'message' => 'unauthorized'
        ],200);
        }
    }

    function sendotpcode(Request $request){
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();
        if ($count === 1){
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', '=', $email)->update(['otp'=>$otp]);
            return response()->json([
                "status" => "success",
                "message" => "Send OTP Mail Successfully"
            ]);
        }
        else {
            return response()->json([
                "status" => "failed",
                "message" => "unathorized"
            ]);
        }
    }

    function Otpverify (Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();

        if($count === 1){
                //update DB password
            User::where('email', '=', $email)->update(['otp'=>0]);

                // JWT token
            $token = JWTToken::createtokenForresetpassword($request->input('email'));
            return response()->json([
                "status" => "Success",
                "message" => "Verified your OTP token"
            ],200)->cookie('token', $token, 60*24*30);
        }
        else
        {
            return response()->json([
                "status" => "Failed",
                "message" => "unothorized"
            ],500);
        }
    }

    function SetPassword(Request $request){
        try {
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email','=', $email)->update(['password'=>$password]);

            return response()->json([
                "status" => "success",
                "message" => "Password update successfully"
            ],200);
        }
        catch (Exception $exception)
        {
            return response()->json([
                "status" => "Field",
                "message" => "Something went wrong"
            ],401);
        }
    }

    function userlogout(){
        return redirect('/')->cookie('token','',-1);
    }

    function userprofile(Request $request){
        $email = $request->header('email');
        $user = User::where('email', '=', $email)->first();
        return response()->json([
            "status" =>  "success",
            "Message" => "Requested successfully",
            "data" => $user
        ],200);
    }

    function profileupdate(Request $request){
        try{
        $email = $request->header('email');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $phone = $request->input('phone');
        $password = $request->input('password');

        User::where('email', '=', $email)->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'password' => $password
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Request successful',
        ],200);
        }
        catch(Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong',
            ],200);
        }
    }

}
