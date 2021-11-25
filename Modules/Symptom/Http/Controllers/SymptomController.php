<?php

namespace Modules\Symptom\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Modules\Doctor\Entities\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use Modules\Symptom\Entities\Symptom;
use Modules\Symptom\Transformers\SymptomResource;
use Modules\Symptom\Transformers\TrackedSymptomResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Symptom\Http\Requests\CreateSymptomRequest;
use Modules\Symptom\Http\Requests\SearchSymptomRequest;
use Modules\Symptom\Http\Requests\UpdateSymptomRequest;
use Modules\Symptom\Http\Requests\TrackSymptomRequest;
use Modules\Symptom\Http\Requests\UpdateTrackedSymptomRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SymptomController extends Controller
{
    

    /**
     * Fetch all symptoms from the database
     * @param null
     * @return ResourceCollection
     */
    public function getAllSymptoms($get = null): ResourceCollection
    {
        if($get == "true"){
            $symptoms = Symptom::get();
        }else{
        /**
         * @var Symptom $symptoms
         */
        $symptoms = Symptom::paginate(10);
        }
        
        return SymptomResource::collection($symptoms);
    }

    /**
     * Get symptoms based on search query
     * @param SearchSymptomRequest $request
     * @return JsonResponse
     * @return ResourceCollection
     */
    public function getSymptoms(SearchSymptomRequest $request)
    {
        /**
         * @var Symptom $symptoms
         */
        
        $symptoms = Symptom::where('name', 'regexp', "$request->symptom")->paginate(2);

        if(count($symptoms) == 0){
            return response()
            ->json(['Sorry, symptom not found']);
        }else{
            return SymptomResource::collection($symptoms);
        }
         

    }

    /**
     * Update resource
     * @param UpdateSysmptomRequest $request
     * @param $uuid
     * @return JsonResponse
     */
    public function updateSymptom(UpdateSymptomRequest $request, $uuid): JsonResponse
    {
        /**
         * @var Symptom $symptom
         */
        $symptom = Symptom::findUuid($uuid);

        $symptom->update([
            'name' => $request->name
        ]);
        return response()
        ->json(["Symptom update successful"]);
    }

    /**
     * view resource
     * @param $uuid
     * @return JsonResponse
     */
    public function showSymptom($uuid)//: SymptomResource
    {
        /**
         * @var Symptom $symptom
         */
       //$symptom = Symptom::findUuid($uuid);
    
        
       // return new SymptomResource($symptom);
        //$user = Doctor::findUuid($uuid);
        $user = Auth::user();

        //$tokenId = $user->token()->id;
        return response()->json([$user->token()->id]);
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateSymptomRequest $request
     * @return JsonResponse
     */
    public function storeSymptom(CreateSymptomRequest $request): JsonResponse
    {
        //
        $symptom = Symptom::create([
            'name' => $request->input('name')
        ]);
        return response()->json(['Symptom creation successful']);
    }

    /**
     * Delete resource
     * @param $uuid
     * @return JsonResponse
     */
    public function deleteSymptom($uuid)
    {
        /**
         * @var Symptom $symptom
         */
        $symptom = Symptom::findUuid($uuid);

        $symptom->delete();
        
        return response()->json(['Symptom deleted']);
    }

    /**
     * Get all tracked symptoms
     * @return JsonResponse
     */
    public function getTrackedSymptoms(){
        $user = Auth::user();

        $symptoms = $user->symptoms;
        
        $symptomNames = [];
        for($i = 0; $i < count($symptoms); $i++){
            $symptomNames[$symptoms[$i]->uuid] = $symptoms[$i]->name;
        };
        $freeSymptomNames = collect($symptomNames)->unique();
        
        return response()->json([$freeSymptomNames]);

    }
    
    /**
     * Get specific tracked symptom
     * @param $uuid
     * @return ResourceCollection
     */
    public function getTrackedSymptom($uuid): ResourceCollection
    {

        $user = Auth::user();

        $symptomId = Symptom::findUuid($uuid)->id;
        $symptoms = $user->symptoms()
        ->where('id', $symptomId)
        ->get();
        
        $sortedSymptoms = collect($symptoms)->sortByDesc('pivot');
        return TrackedSymptomResource::collection($sortedSymptoms);
        //return response()->json([$symptoms]);
    }

    /**
     * Show tracked symptom
     * @param $uuid, $created_at
     * @return TrackedSymptomResource
     * 
     */
    public function showTrackedSymptom($uuid, $created_at): TrackedSymptomResource
    {
        $user = Auth::user();
        $userId = $user->id;
        $role = basename(get_class($user));
        $symptomId = Symptom::findUuid($uuid)->id;

        $symptoms = $user->symptoms()
        ->where('id', $symptomId)
        ->get();

        $targetSymptom = "";
        
        foreach($symptoms as $symptom){
            if($symptom->pivot->created_at->toDateTimeString() == $created_at){
                $targetSymptom = $symptom;
                //return response()->json(["Yeez, tumemake" => $targetSymptom]);
                return new TrackedSymptomResource($targetSymptom);
            }
        }

    }

    /**
     * Edit Tracked Symptom
     * @param UpdateTrackedSymptom
     * @return JsonResponse
     */
    public function EditTrackedSymptom(UpdateTrackedSymptomRequest $request): UpdateTrackedSymptom
    {
        $user = Auth::user();
        $userId = $user->id;
        $role = basename(get_class($user));
        $symptomId = Symptom::findUuid($request->uuid)->id;

        $update = DB::table('symptom_user')
        ->where('user_id', $userId)
        ->where('symptom_id', $symptomId)
        ->where('created_at', $request->created_at)
        ->where('user', $role)
        ->update([
            'severity' => $request->severity,
            'description' => $request->description
            ]);
        return response()->json(["Udpate Status" => $update]);

    }

    /**
     * Delete Tracked Symptom
     */
    public function deleteTrackedSymptom($uuid, $created_at)
    {
        $user = Auth::user();
        $userId = $user->id;
        $role = basename(get_class($user));
        $symptomId = Symptom::findUuid($uuid)->id;

        DB::table('symptom_user')
        ->where('user_id', $userId)
        ->where('symptom_id', $symptomId)
        ->where('created_at', $created_at)
        ->where('user', $role)
        ->delete();

        return response()->json(["Delete Status" => "deleted"]);

    }

    /**
     * Track symptom of certain user
     * @param TrackSymptomRequest $request
     * @return JsonResponse
     */
    public function trackSymptom(TrackSymptomRequest $request): JsonResponse
    {
        /**
         * @var User $userId
         */
        $user = Auth::user();
        
        $symptomId = Symptom::findUuid($request->symptom_uuid)->id;
        $role = basename(get_class($user));
        $user->symptoms()->attach($symptomId, [
            'severity' => $request->severity, 
            'description' => $request->description, 
            'user' => $role,
            //'created_at' => Carbon::now()->toDateTimeString()
        ]);
        return response()->json(["Tracking Successful"], 200);

    }
}
