<?php

namespace App\Http\Controllers;

use App\Helpers\MediaHelper;
use App\Mail\BlockUserMail;
use App\Mail\UnBlockUserMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $valide = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
        $user = User::where('email', $request['email'])
            ->first();
        if (!$user) {
            return response()->json(['message' => 'لا يوجد مستخدم بهذا الحساب'], 404);
        }
        if ($user->block) {
            return response()->json([
                'message' => 'حسابك هذا تم حظره بسبب انتهاك خصوصية موقعنا',
                'status' => 'blocked',
                'code' => 403
            ], 403);
        }
        if (!Hash::check($valide['password'], $user->password)) {
            return response()->json(['message' => 'كلمة المرور غير صحيحة'], 401);
        }
        if ($user->role === 'user') {
            return response()->json(['message' => 'لا يمكنك تسجيل الدخول من هنا'], 400);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['data' => ['token' => $token]], 200);
    }
    public function getPolice(Request $request)
    {
        $polices = User::where('role', 'police')->paginate(10);
        return $polices;
    }
    public function getUsers(Request $request)
    {
        $users = User::where('role', 'user')->paginate(10);
        return  $users;
    }
    public function blockUser(User $user)
    {
        try {
            Mail::to($user->email)->queue(new BlockUserMail($user));
        } catch (Exception $e) {
            return $e->getMessage();
        }
        $user->block();
        return $user;
    }
    public function UnblockUser(User $user)
    {
        try {
            Mail::to($user->email)->queue(new UnBlockUserMail($user));
        } catch (Exception $e) {
            return $e->getMessage();
        }
        $user->Unblock();
        return $user;
    }
    public function createPolice(Request $request)
    {
        try {
            $validate = $request->validate([
                'firstname' => 'string',
                'lastname' => 'string',
                'email' => 'email|required',
                'profile_image' => 'file|mimes:jpeg,png,jpg',
                'gender' => 'required|in:male,female',
                'password' => 'required|min:8',
                'phone' => 'required|digits:10',
                'badge_number' => 'required',
                'national_number' => 'required'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
        $userEx = User::where('email', $request['email'])->exists();
        if ($userEx) {
            return response()->json(['message' => 'User has been exist'], 400);
        }
        if ($request->hasFile('profile_image')) {
            $path = MediaHelper::StoreMedia('profileImage', $request, 'profile_image');
            $validate['profile_image'] = $path;
        }
        $validate['role'] = 'police';
        $user = User::create($validate);
        return response()->json(['data' => $user], 200);
    }
    public function updatePolice(Request $request, User $user)
    {
        try {
            $validate = $request->validate([
                'firstname' => 'string|nullable',
                'lastname' => 'string|nullable',
                'email' => 'email|nullable',
                'birthday' => 'date|nullable',
                'gender' => 'nullable|in:male,female',
                'password' => 'nullable|min:8',
                'phone' => 'nullable|digits:10',
                'profile_image' => 'file|mimes:jpeg,png,jpg'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
        if (!$user) {
            return response()->json(['message' => 'Police not found'], 404);
        }
        if ($request->hasFile('profile_image')) {
            $path = MediaHelper::StoreMedia('profileImage', $request, 'profile_image');
            $validate['profile_image'] = $path;
        }
        return response()->json([
            'message' => 'Police officer updated successfully',
            'data' => $user
        ], 200);
    }
    public function deletePolice(User $user)
    {
        if ($user->delete()) {
            return response()->json(['message' => 'delete succesfully'], 200);
        }
        return response()->json(['message' => 'can not delete this police'], 400);
    }
}
