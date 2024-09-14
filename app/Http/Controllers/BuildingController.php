<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\BuildingModel;
use Illuminate\Http\Request;

include('ConstFunction.php');

class BuildingController extends Controller
{
    public function getAllBuildingData(Request $request)
    {
        $data = BuildingModel::all();
        if (count($data)) {
            return messageRequest('success', $data);
        } else {
            return messageRequest('Warning', "data is empty");
        }
    }

    public function getBuildingById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idBuliding' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return messageRequest("error", $validator->errors());
        }
        $building = BuildingModel::find($request->idBuliding);
        if ($building) {
            return messageRequest('success', $building);
        } else {
            return messageRequest('Warning', "data is empty");
        }
    }

    public function insertBuilding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'building_name' => 'required|string|max:50',
            'building_number' => 'required|numeric',
            'building_la' => 'required|numeric',
            'building_lo' => 'required|numeric',
            'building_count_floor' => 'required|string',
        ]);

        if ($validator->fails()) {
            return messageRequest("error", $validator->errors());
        }

        $checkAdd = BuildingModel::where('building_name', '=', $request->building_name)->orwhere('building_number', '=', $request->building_number)->first();
        if ($checkAdd) {
            return messageRequest('Warning', "Building is already add");
        }

        $building = new  BuildingModel();
        $building->building_name = $request->building_name;
        $building->building_number = $request->building_number;
        $building->building_la = $request->building_la;
        $building->building_lo = $request->building_lo;
        $building->building_count_floor = $request->building_count_floor;
        //First add default value =  1    0=>inactive |  1=>active
        $building->building_active = 1;
        if ($building->save()) {
            return messageRequest('success', "Add Building Successfuly");
        } else {
            return messageRequest('Warning', "Something went wrong.");
        }
    }

    public function deleteBuilding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idBuliding' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return messageRequest("error", $validator->errors());
        }

        $building = BuildingModel::find($request->idBuliding);
        if ($building) {
            $building->delete();
            return messageRequest('success', "Delete Building Successfuly");
        } else {
            return messageRequest('Warning', "Building Is Not Found.");
        }
    }

    public function ubdateBuilding(Request $request){

    }
}
