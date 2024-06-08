<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parents;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAuthController extends Controller
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
    public function adminRegister(Request $request): JsonResponse
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

            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = Hash::make($request->password);
            $newUser->mobile_no = $request->mobile_no;
            $newUser->is_admin = true;
            $newUser->status = "active";
            $newUser->save();

            $response = [
                'userData' => $newUser,
            ];
            return $this->sendResponse($response, 'Admin registered successfully.', true);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $e->getTrace(), 413);
        }
    }
    public function adminLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $token = JWTAuth::fromUser($user);
                $response = ['token' => $token];
                $response['userData'] = $user;
                return $this->sendResponse($response, 'Admin logged in successfully.', 200);
            }
            return $this->sendError("Invalid credentials", [], 401);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $e->getTrace(), 500);
        }
    }
}
