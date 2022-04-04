<?php

namespace Modules\Authentication\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Patient\Entities\Patient;
use Modules\Doctor\Entities\Doctor;
use Modules\Authentication\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request): JsonResponse
    {
        $patient = Patient::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number
        ]);

        return response()->json(['status' => 'success', 'message' => 'User registered']);
    }

    public function registerDoctor(Request $request): JsonResponse
    {
        Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required'],
            'password' => ['required', 'min:6'],
            'email' => ['required', 'string', 'email', 'max:255', 'exists:doctors'],
        ])->validate();

        $doctor = Doctor::where('email', $request->email)->first();

        if ($doctor) {
            $doctor->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'User registered']);
    }


}
