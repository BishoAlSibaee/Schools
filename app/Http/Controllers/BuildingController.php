<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\BuildingModel;
use Exception;
use Illuminate\Http\Request;

include('ConstFunction.php');

class BuildingController extends Controller
{
    public function getAllBuildingData()
    {
        $data = BuildingModel::all();
        if (count($data) > 0) {
            return messageRequest(1, 'success', $data);
        } else {
            return messageRequest(0, 'Warning', "data is empty");
        }
    }

    public function getBuildingById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idBuliding' => 'required|numeric|exists:building,id',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }

        return messageRequest(1, "success", BuildingModel::find($request->idBuliding));
    }

    public function insertBuilding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'building_name' => 'required|string|max:50|unique:building,building_name',
            'building_number' => 'required|numeric|unique:building,building_number',
            'building_la' => 'required|numeric',
            'building_lo' => 'required|numeric',
            'building_count_floor' => 'required|string',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }

        $building = new  BuildingModel();
        $building->building_name = $request->building_name;
        $building->building_number = $request->building_number;
        $building->building_la = $request->building_la;
        $building->building_lo = $request->building_lo;
        $building->building_count_floor = $request->building_count_floor;
        //First add default value =  1    0=>inactive |  1=>active
        $building->building_active = 1;
        try {
            $building->save();
            return messageRequest(1, 'success', "Add Building Successfuly");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    public function deleteBuilding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idBuliding' => 'required|numeric|exists:building,id',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }


        try {
            $building = BuildingModel::find($request->idBuliding);
            $building->delete();
            return messageRequest(1, 'success', "Delete Building Successfuly");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    public function ubdateBuilding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:building,id',
            'building_name' => 'nullable|string|max:50',
            'building_number' => 'nullable|integer',
            'building_la' => 'nullable|numeric',
            'building_lo' => 'nullable|numeric',
            'building_count_floor' => 'nullable|integer',
            'building_active' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }
        $building = BuildingModel::find($request->id);
        if ($request->has('building_name')) {
            $building->building_name = $request->building_name;
        }

        if ($request->has('building_number')) {
            $building->building_number = $request->building_number;
        }

        if ($request->has('building_la')) {
            $building->building_la = $request->building_la;
        }

        if ($request->has('building_lo')) {
            $building->building_lo = $request->building_lo;
        }

        if ($request->has('building_count_floor')) {
            $building->building_count_floor = $request->building_count_floor;
        }

        if ($request->has('building_active')) {
            $building->building_active = $request->building_active;
        }

        try {
            $building->save();
            return messageRequest(1, 'success', "Building updated successfully");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }
}
