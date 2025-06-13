<?php

namespace App\Http\Controllers;

use App\Mail\BlockUserMail;
use App\Mail\UnBlockUserMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    public function getPolice(Request $request)
    {
    $polices = User::where('role','police')->paginate(10);
    return $polices;
    }
    public function getUsers(Request $request)
    {
        $users = User::where('role','user')->paginate(10);
        return  $users;
    }
    public function blockUser(User $user)
    {
        try{
            Mail::to($user->email)->queue(new BlockUserMail($user));
        }catch(Exception $e){
            return $e->getMessage();
        }
        $user->block();
        return $user;
    }
    public function UnblockUser(User $user)
    {
          try{
            Mail::to($user->email)->queue(new UnBlockUserMail($user));
        }catch(Exception $e){
            return $e->getMessage();
        }
        $user->Unblock();
        return $user;
    }
    public function createPolice(Request $request)
    {
         try{
            $validate=$request->validate([
                'firstname' => 'string',
                'lastname' => 'string',
                'email' => 'email|required',
                'birthday' => 'date|required',
                'gender' => 'required|in:male,female',
                'password' => 'required|min:8',
                'phone' => 'required|digits:10',
                'badge_number' => 'required',
            ]);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
        $userEx=User::where('email',$request['email'])->exists();
        if($userEx)
        {
            return response()->json(['message' => 'User has been exist'],400);
        }
        $validate['role'] = 'police';
        $user=User::create($validate);
        return response()->json(['data' => $user],200);
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
        $user->update($validate);
        return response()->json([
            'message' => 'Police officer updated successfully',
            'data' => $user
        ], 200);
    }
    public function deletePolice(User $user)
    {
        if($user->delete()){
            return response()->json(['message' => 'delete succesfully'],200);
        }
        return response()->json(['message' => 'can not delete this police'],400);
    }
}
