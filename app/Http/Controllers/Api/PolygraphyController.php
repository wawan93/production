<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PolygraphyApproved;
use App\PolygraphyType;
use App\Team;
use Illuminate\Http\Request;

class PolygraphyController extends Controller
{
    public function codeName($team_id, $polygraphy_type, $format, Request $request)
    {
        $team = Team::find($team_id);
        $polyType = PolygraphyType::where('type', $polygraphy_type);

        if (empty($format)) {
            switch ($polygraphy_type) {
                case 'first_listovka':
                    if ($team->members()->count() >= 3)
                        $format = 'A3';
                    else
                        $format = 'A4';
                    break;
                case 'newspaper1':
                    $polyApproved = PolygraphyApproved::where('team_id', $team_id)
                        ->where('polygraphy_type', $polygraphy_type)
                        ->first();
                    $edition_info = json_decode($polyApproved->edition_info);
                    if (strpos($edition_info->edition_key, 'g50') !== false)
                        $format = 'np';
                    else
                        $format = 'offset';
            }
        } else {
            $format = $format;
        }

        $format = $polyType->where('format', $format)->first();

        $region = $team->region_name;
        $region = str_replace([' ', '-'], '', $region);

        $district = $team->district_number;

        $code_name = $region . $district . $format->order_code;

        return response()->json([
            'error' => 'false',
            'team_id' => $request->get('team_id'),
            'polygraphy_type' => $request->get('polygraphy_type'),
            'code_name' => $code_name,
            'invoice_subject' => $format->mat_name,
        ]);
    }
}