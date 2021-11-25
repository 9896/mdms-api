<?php

namespace Modules\Authentication\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Doctor\Entities\Doctor;
use Modules\Patient\Entities\Patient;
use Modules\Authentication\Http\Requests\AdminLoginRequest;
use Modules\Authentication\Http\Requests\DoctorLoginRequest;
use Modules\Authentication\Http\Requests\PatientLoginRequest;
use Modules\Authentication\Traits\AuthenticationService;

class AuthenticationController extends Controller
{
    use AuthenticationService;

    /**
     * @param AdminLoginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function adminLogin(AdminLoginRequest $request)
    {
        $login = $this->login($request, 'admins');

        return response()->json([
            $login->response,
            $login->status
        ]);
    }

    /**
     * @param DoctorLoginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function doctorLogin(DoctorLoginRequest $request)
    {
        $login = $this->login($request, 'doctors');

        return response()->json([
            $login->response,
            $login->status
        ]);
    }

    /**
     * @param PatientLoginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function patientLogin(PatientLoginRequest $request)
    {
        $login = $this->login($request, 'patients');

        return response()->json([
            $login->response,
            $login->status
        ]);
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

        $user->revokePermissionTo("login");
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

        $user->givePermissionTo("login");
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

        $user->revokePermissionTo("login");

        
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
