<?php

namespace App\Http\Controllers\v1\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustAuthController extends Controller
{
    public function saveFile($file, $fileName)
    {
        $fileExtension = $file->getClientOriginalExtension();
        $newFileName = Str::uuid() . '-' . rand(100, 9999) . '.' . $fileExtension;
        $uploadsPath = public_path('uploads');
        $directoryPath = "$uploadsPath/$fileName";

        if (!File::exists($uploadsPath)) {
            File::makeDirectory($uploadsPath, 0755, true);
        }

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        $destinationPath = "$directoryPath/$newFileName";
        $file->move($directoryPath, $newFileName);

        return "/uploads/$fileName/" . $newFileName;
    }
    public function custRegister(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'mobile_no' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            DB::beginTransaction();
            $otp = rand(1000, 9999);
            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->email_otp = $otp;
            $newUser->email_otp_expiry = Carbon::now()->addMinutes(2);
            $newUser->password = Hash::make($request->password);
            $newUser->mobile_no = $request->mobile_no;
            $newUser->is_admin = false;
            $newUser->save();
            $response = [
                'userData' => $newUser,
            ];
            $data = [
                'to_name' => $newUser['name'],
                'email' => $newUser['email'],
                'otp' => $otp
            ];
            Mail::send('emails.sendOtp', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['to_name'])
                    ->subject('Lonavala Villa OTP for Verification.');
                $message->from(env('MAIL_FROM_ADDRESS'), 'Lonavala Villas');
            });
            DB::commit();
            return $this->sendResponse($response, 'Please verify mail.', true);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage(), $e->getTrace(), 413);
        }
    }
    public function checkOtpAndLoginEmail(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|string',
            ]);
            if ($validator->fails()) {
                return $this->sendError("Validation failed", $validator->errors());
            }
            $user = User::query()->where('email', $request->email)->first();
            if (!$user) {
                return $this->sendError('User does not exist or user doesn\'t have access', [], 401);
            }
            if ($user->email_otp != $request->otp) {
                return $this->sendError("Validation failed", ['otp' => 'Invalid OTP']);
            }
            if ($user->email_otp_expiry < Carbon::now()) {
                return $this->sendError("Validation failed", ['otp' => 'Expired OTP']);
            }
            $user->email_otp = null;
            $user->email_otp_expiry = null;
            $user->status = "active";
            $user->save();
            $token = JWTAuth::fromUser($user);
            $response = ['token' => $token];
            $response['userData'] = $user;
            return $this->sendResponse($response, 'Login Success', 200);
        } catch (Exception $e) {
            return $this->sendError("Something went wrong", [$e->getMessage()], 500);
        }
    }
    public function custLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $user = User::where('email', $request->email)->where('status', 'active')->where('is_admin', 'false')->first();
            if (!$user) {
                return $this->sendError('User does not exist or user doesn\'t have access');
            }
            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $token = JWTAuth::fromUser($user);
                $response = ['token' => $token];
                $response['userData'] = $user;
                return $this->sendResponse($response, 'User logged in successfully.', 200);
            }
            return $this->sendError("Invalid credentials", [], 401);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $e->getTrace(), 500);
        }
    }
}
