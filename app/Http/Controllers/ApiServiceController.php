<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
use App\BuildingBusiness;
use App\BuildingRent;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ApiServiceController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    // public function index(Request $request)
    // {
    //     return response()->json(['message' => 'Access granted to protected API'], 200);
    // }

    public function apiLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            
            // Generate a new API token for the user
            $token = Str::random(60); // Generate a random string for token
            
            $user->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();
    
            return response()->json(['token' => $token], 200);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    

    public function getBinDetails($bin) {
        try {
            // Fetch Building data
            $building = Building::findOrFail($bin);
    
            // Initialize variables for business and rent
            $business = "No Business registegred for BIN $bin";
            $rent = "No Rent registegred for BIN $bin";
    
            // fetch BuildingBusiness and BuildingRent data
            try {
                $business = BuildingBusiness::where('bin', $bin)->get();
            } catch (ModelNotFoundException $e) {
                Log::warning("No BuildingBusiness found for BIN $bin.");
            }
    
            try {
                $rent = BuildingRent::where('bin', $bin)->get();
            } catch (ModelNotFoundException $e) {
                Log::warning("No BuildingRent found for BIN $bin.");
            }
    
           $map =  $this->viewMap($bin);
            // Return JSON response with success and data
            return response()->json([
                'success' => true,
                'data' => [
                    'building' => $building,
                    'business' => $business,
                    'rent' => $rent,
                    'map' =>  $map
                ],
                'message' => 'BIN Details retrieved successfully.'
            ]);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "No BIN found for ID $bin."
            ], 404); // Use 404 for resource not found
    
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500); // Internal Server Error for other exceptions
        }
    }

    public function viewMap($bin)
    {
        $url = action('MapsController@index', [
            'layer' => 'bldg',
            'field' => 'bin',
            'val' => $bin
        ]);
    
        return $url;
    }

    public function updateBuilding(Request $request, $bin)
    {
        $inputData = $request->all();
  
        $resource = Building::where('bin', $bin)->first();

        if ($resource) {
            $resource->bldguse = $request->input('bldguse');
            $resource->yoc = $request->input('yoc');
            $resource->flrcount = $request->input('flrcount');
            $resource->consttyp = $request->input('consttyp');
            $resource->toilyn = $request->input('toilyn');
            $resource->hhcount = $request->input('hhcount');
            $resource->hhpop = $request->input('hhpop');
            $resource->txpyrid = $request->input('txpyrid');
            $resource->txpyrname = $request->input('txpyrname');
            $resource->flrar = $request->input('flrar');
            $resource->bprmtno = $request->input('bprmtno');
            $resource->offcnm = $request->input('offcnm');
            $resource->bldgcd = $request->input('bldgcd');
            $resource->ward = $request->input('ward');
            $resource->tole = $request->input('tole');
            $resource->strtcd = $request->input('strtcd');
            $resource->hownr = $request->input('hownr');
            $resource->flrar = $request->input('flrar');

     
                $resource->save();
    
                return response()->json(['message' => 'Building updated successfully', 'resource' => $resource]);
            } else {
                return response()->json(['error' => 'Building not found'], 404);
            }
        }
}