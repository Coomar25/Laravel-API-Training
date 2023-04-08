<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // 
    //     $users = User::all();
    //     // $users = User::select('id', 'name', 'email', 'status')->where('status', 1)->get();
    //     if (count($users) > 0) {
    //         $response = [
    //             'message' => count($users) . 'users found',
    //             'status' => 1,
    //             'data' => $users
    //         ];
    //         return response()->json($response, 200);
    //     } else {
    //         $response = [
    //             'message' => count($users) . 'users not found',
    //             'status' => 0
    //         ];
    //         return response()->json($response, 404);
    //     }

    // }

    public function index($flag)
    {
        // if $flag=1 (active users)
        //if $flag=0  (all Users)

        // $users = User::all();
        $query = User::select('name', 'email');
        if ($flag == 1) {
            $query->where('status', 1);
        } elseif ($flag == 0) {
            $query->where('status', 0);
        } else {
            return response()->json([
                'message' => 'Invalid parameter passed, it can either be 1 or zero',
                'status' => 'unknown'
            ], 400);
        }
        $users = $query->get();



        if (count($users) > 0) {
            $response = [
                'message' => count($users) . 'users found',
                'status' => 1,
                'data' => $users
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => count($users) . 'users not found',
                'status' => 0
            ];
            return response()->json($response, 404);
        }

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid_Data = Validator::make($request->all(), [
            'name' => ['required'],
            // 'email' => ['required', 'accepted', 'unique:table,column,except,id'];
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        if ($valid_Data->fails()) {
            return response()->json($valid_Data->messages(), 400);
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                // 'password' => Hash::make($request->password),
                // 'password_confirmation' => $request->password_confirmation
            ];
            p($data);
            DB::beginTransaction();
            try {
                $validuser = User::create($data);
                DB::commit();
            } catch (Exception $ex) {
                DB::rollBack();
            }

            if ($validuser) {
                echo "user ko data xiiryo database ma yo chai validation vaye vane matra show garxa message";
            } else {
                echo "error occured during transfer of data";
            }
        }

        // $request->validate([
        //     'name' => ['required'],
        //     'email' => ['required'],
        //     'password' => ['required'],
        //     'confirmpassword' => ['required']
        // ]);

        // p($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        if (is_null($user)) {
            echo "User not found or below message in json format";
            $response = [
                'message' => 'User not Found',
                'status' => 0
            ];
        } else {
            $response = [
                'message' => 'user found',
                'status' => 1
            ];
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}