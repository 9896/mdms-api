<?php

namespace Modules\Patient\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Patient\Transformers\PatientResource;
use Modules\Patient\Http\Requests\UpdatePatientRequest;
use Modules\Patient\Entities\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class PatientController extends Controller
{

    /**
     * view resource
     * @param $uuid
     * @return JsonResponse
     */
    public function showPatient(): PatientResource
    {
       /**
        * @var Patient $patient
        */
        $patient = Auth::user();
        
        return new PatientResource($patient);
    }

    /**
     * Update resource
     * @param UpdatePatientRequest $request
     * @param $uuid
     * @return JsonResponse
     */
    public function updatePatient(UpdatePatientRequest $request): JsonResponse
    {   
        /**
         * @var Patient $patient
         */
        $patient = Auth::user();

        $patient->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number
        ]);
        return response()
        ->json(["Patient update successful"]);
    }
}
