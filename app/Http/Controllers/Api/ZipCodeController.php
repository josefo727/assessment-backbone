<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ZipCode;
use App\Http\Resources\ZipCodeResource;
use Illuminate\Http\Response;

class ZipCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke($zipCode)
    {
        $zipCodeInfo = ZipCode::query()
            ->with(['federalEntity', 'settlements', 'municipality'])
            ->where('zip_code', $zipCode)
            ->first();

        if (!$zipCodeInfo) {
            return response()->json([
                'message' => 'Zip code not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $zipCode = new ZipCodeResource($zipCodeInfo);
        return response()->json($zipCode, Response::HTTP_OK);
    }
}
