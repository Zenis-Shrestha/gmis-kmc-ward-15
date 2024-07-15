<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
use App\BuildingBusiness;
use App\BuildingRent;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class ApiServiceController extends Controller
{
   

    public function apiLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Passport::tokensExpireIn(now()->addSeconds(10));
            $token = $user->createToken('Personal Access Token')->accessToken;
            $user->api_token = $token;
            $user->save();
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
}
    


    public function getBinDetails($bin, Request $request)
    {

        try {
            // Fetch Building data
            $building = Building::select('bin', 'bldgcd', 'ward', 'tole', 'oldhno', 'strtcd', 'bldgasc', 'bldguse', 
            'offcnm', 'hownr', 'yoc', 'flrcount', 'flrar', 'consttyp', 'bprmtyn', 'bprmtno', 'toilyn', 'sbin', 
            'txpyrname', 'txpyrid', 'btxyr', 'btxsts', 'businessno', 'rentno', 'house_photo', 'house_new_photo')
            ->findOrFail($bin);
    
            // Initialize variables for business and rent
            $business = "No Business registegred for BIN $bin";
            $rent = "No Rent registegred for BIN $bin";
    
            // fetch BuildingBusiness and BuildingRent data
            try {
                $business = BuildingBusiness::select(
                    'id', 'ward', 'roadname', 'houseno', 'bin', 'houseownername', 'ownerphone', 
                    'houseownermail', 'businesowner', 'businessname', 'businesstype', 'category', 
                    'businessoprdate', 'registration', 'oldinternalnumber', 'taxlastdate', 'rent', 
                    'rentresponsible', 'businessownermobile', 'email', 'remarks', 'business_tax_rates_id', 
                    'businessmaintype', 'registration_status'
                )->where('bin', $bin)->get();
                
            } catch (ModelNotFoundException $e) {
                Log::warning("No BuildingBusiness found for BIN $bin.");
            }
           
            try {
                $rent = BuildingRent::select(
                    'id', 'ward', 'roadname', 'houseno', 'bin', 'taxpayercode', 'hownername', 'hownernumber', 
                    'howneremail', 'housetype', 'length', 'width', 'area', 'rentername', 'rentpurpose', 
                    'rentstart', 'rentend', 'monthlyrent', 'rentaxresponsible', 'rentincreseperyear', 
                    'rentmobilenumber', 'remarks'
                )->where('bin', $bin)->get();
            } catch (ModelNotFoundException $e) {
                Log::warning("No BuildingRent found for BIN $bin.");
            }
            $token_map = Auth::user()->api_token;
            $map = route('redirect-to-map', ['bin' => $bin]) . '?token=' . Crypt::encrypt(urlencode($token_map));
            // Return JSON response with success and data
            return response()->json([
                'success' => true,
                'data' => [
                    'building' => $building,
                    'business' => $business,
                    'rent' => $rent,
                    'mapUrl' =>  $map
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
            ], 500); 
    }
    }

    public function redirectToMap($bin) 
    {
        
        return redirect()->action('MapsController@viewBin', [
            'layer' => 'bldg',
            'field' => 'bin',
            'val' => $bin
        ]);
    }

    public function updateBuilding(Request $request, $bin)
    {
        $resource = Building::where('bin', $bin)->first();
        if ($resource) {
            $validator = Validator::make($request->all(), [
                'oldhno' => 'nullable|string',
                'txpyrname' => 'nullable|string',
                'txpyrid' => 'nullable|string',
                'flrcount' => 'nullable|integer',
                'consttyp' => 'nullable|integer',
                'yoc' => 'nullable|integer',
                'ward' => 'nullable|string',
                'strtcd' => 'nullable|integer',
                'flrar' => 'nullable|string',
                'sbin' => 'nullable|string',
                'tole' => 'nullable|string',
                'hownr' => 'nullable|string',
                'bprmtno' => 'nullable|string',
                'btxyr' => 'nullable|string',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }
    
            // Update fields based on request input or set to null if not provided
            $resource->oldhno = $request->input('oldhno') !== '' ? $request->input('oldhno') : null;
            $resource->txpyrname = $request->input('txpyrname') !== '' ? $request->input('txpyrname') : null;
            $resource->txpyrid = $request->input('txpyrid') !== '' ? $request->input('txpyrid') : null;
            $resource->flrcount = $request->input('flrcount') !== '' ? $request->input('flrcount') : null;
            $resource->consttyp = $request->input('consttyp') !== '' ? $request->input('consttyp') : null;
            $resource->yoc = $request->input('yoc') !== '' ? $request->input('yoc') : null;
            $resource->ward = $request->input('ward') !== '' ? $request->input('ward') : null;
            $resource->strtcd = $request->input('strtcd') !== '' ? $request->input('strtcd') : null;
            $resource->flrar = $request->input('flrar') !== '' ? $request->input('flrar') : null;
            $resource->sbin = $request->input('sbin') !== '' ? $request->input('sbin') : null;
            $resource->tole = $request->input('tole') !== '' ? $request->input('tole') : null;
            $resource->hownr = $request->input('hownr') !== '' ? $request->input('hownr') : null;
            $resource->bprmtno = $request->input('bprmtno') !== '' ? $request->input('bprmtno') : null;
            $resource->btxyr = $request->input('btxyr') !== '' ? $request->input('btxyr') : null;
    
            $resource->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Building updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Building not found'
            ], 404);
        }
    }
    

    public function deleteBuilding(Request $request, $bin)
    {
        $resource = Building::where('bin', $bin)->first();
    
        if ($resource) {
            $resource->delete();
            return response()->json([
                'status' => true,
                'message' => 'Building deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Building not found'
            ], 404);
        }
    }
    


       
}