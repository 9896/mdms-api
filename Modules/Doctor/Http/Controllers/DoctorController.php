<?php

namespace Modules\Doctor\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Doctor\Entities\Doctor;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Doctor\Transformers\DoctorResource;
use Modules\Doctor\Http\Requests\CreateDoctorRequest;


class DoctorController extends Controller
{
    /**
     * Return an instance of the admin
     * 
     * @return DoctorResource
     */
    public function me():DoctorResource
    {
        $user = Auth::user();
        
        return new DoctorResource($user);
    }
    /**
     * Get all doctors
     * @return ResourceCollection
     */
    public function getAllDoctors(): ResourceCollection
    {
        $doctors = Doctor::paginate(10);
        
        return DoctorResource::collection($doctors);
    }


    /**
     * Create/Register Doctor
     * @param  CreateDoctorRequest $request
     * @return JsonResponse
     */
    public function storeDoctor(CreateDoctorRequest $request): JsonResponse
    {
        $hashedPassword = Hash::make($request->password);
        $doctor = Doctor::create([
            // 'first_name' => $request->first_name,
            // 'last_name' => $request->last_name,
            'email' => $request->email,
            // 'phone_number' => $request->phone_number,
            // 'password' => $hashedPassword,
        ]);

        return response()->json(['Doctor Created Succefully']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('doctor::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('doctor::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
