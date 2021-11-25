<?php

namespace Modules\Admin\Http\Controllers;

use Auth;
use Modules\Admin\Entities\Admin;
use Modules\Doctor\Entities\Doctor;
use Modules\Patient\Entities\Patient;
use Modules\Admin\Transformers\AdminResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{

    /**
     * Return an instance of the admin
     * 
     * @return adminResource
     */
    public function me():AdminResource
    {
        $user = Auth::user();
        
        return new AdminResource($user);
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::edit');
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

    /**
     * give Login Permission
     * @param uuid
     * @return JsonResponse
     * 
     */
    public function grantDoctorLogin($uuid)
    {
        $user = Doctor::findUuid($uuid);

        $user->givePermissionTo("login");

        
    }

    /**
     * Revoke Login Permission
     * @param uuid
     * @return JsonResponse
     * 
     */
    public function revokeDoctorLogin($uuid)
    {
        $user = Doctor::findUuid($uuid);
        return response()->json([$user->token()->id]);
        $tokenId = $user->token()->id;

        // Revoke an access token...
        $tokenRepository->revokeAccessToken($tokenId);

        // Revoke all of the token's refresh tokens...
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        $user->revokePermissionTo("login");

        return response()->json(["Login permission revoked"]);
    }

        /**
     * give Login Permission
     * @param uuid
     * @return JsonResponse
     * 
     */
    public function grantPatientLogin($uuid)
    {
        $user = Patient::findUuid($uuid);

        $user->givePermissionTo("login1");
    }

    /**
     * Revoke Login Permission
     * @param uuid
     * @return JsonResponse
     * 
     */
    public function revokePatientLogin($uuid)
    {
        $user = Patient::findUuid($uuid);
        $tokenId = $user->token()->id;

        // Revoke an access token...
        $tokenRepository->revokeAccessToken($tokenId);

        // Revoke all of the token's refresh tokens...
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
        

        $user->revokePermissionTo("login1");

        return response()->json(["Login permission revoked"]);

        
    }

    /**
     * give create, update, login Permission
     * @param uuid
     * @return JsonResponse
     * 
     */
    public function grantDoctorCUD($uuid)
    {
        $user = Doctor::findUuid($uuid);

        $user->givePermissionTo("CUD1");

        return response()->json(["CUD permissions Granted"]);
    }

    /**
     * Revoke create, update, delete Permission
     * @param uuid
     * @return JsonResponse
     * 
     */
    public function revokeDoctorCUD($uuid)
    {
        $user = Doctor::findUuid($uuid);

        $user->revokePermissionTo("CUD1");

        return response()->json(["CUD permission Revoked"]);
    }
}
