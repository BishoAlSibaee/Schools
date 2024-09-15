<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\FloorModel;
use Illuminate\Http\Request;
use Exception;
use App\Models\BuildingModel;


include('ConstFunction.php');


class FloorController extends Controller
{
    public function getAllFloorData()
    {
        $data = FloorModel::all();
        if (count($data) > 0) {
            return messageRequest(1, 'success', $data);
        } else {
            return messageRequest(0, 'Warning', "data is empty");
        }
    }

    public function getFloorById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idFloor' => 'required|numeric|exists:floor,id',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }
        return messageRequest(1, "success", FloorModel::find($request->idFloor));
    }

    public function insertFloor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_building' => 'required|numeric',
            'floor_number' => 'required|numeric',
            'floor_count_classes' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }
        //Check Building
        if ($this->checkBuilding($request->id_building)) {
            return messageRequest(-1, "error", "Building does not exist.");
        }

        //Check Floor inside Building
        if ($this->checkFloor($request->id_building, $request->floor_number)) {
            return messageRequest(-1, "error", "The floor already exists in this building.");
        }

        $floor = new  FloorModel();
        $floor->id_building = $request->id_building;
        $floor->floor_number = $request->floor_number;
        $floor->floor_count_classes = $request->floor_count_classes;

        try {
            $floor->save();
            return messageRequest(1, 'success', "Add Floor Successfuly");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    public function deleteFloor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idFloor' => 'required|numeric|exists:floor,id',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }

        try {
            $floor = FloorModel::find($request->idFloor);
            $floor->delete();
            return messageRequest(1, 'success', "Delete Floor Successfuly");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    public function ubdateFloor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:floor,id',
            'floor_number' => 'nullable|numeric',
            'floor_count_classes' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }

        $floor = FloorModel::find($request->id);
        if ($request->has('floor_number')) {

            if ($this->checkFloor($floor->id_building, $request->floor_number)) {
                return messageRequest(-1, "error", "The floor already exists in this building.");
            }
            $floor->floor_number = $request->floor_number;
        }

        if ($request->has('floor_count_classes')) {
            $floor->floor_count_classes = $request->floor_count_classes;
        }

        try {
            $floor->save();
            return messageRequest(1, 'success', "Floor updated successfully");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    function checkBuilding($id_building)
    {
        $building = BuildingModel::find($id_building);
        if (!$building) {
            return true;
        }
        return false;
    }

    function checkFloor($id_building, $floor_number)
    {
        $floor = FloorModel::where('id_building', $id_building)->where('floor_number', $floor_number)->first();
        if ($floor) {
            return true;
        }
        return false;
    }
}
