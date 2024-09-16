<?php

namespace App\Http\Controllers;

use App\Models\StageModel;
use Validator;

use Illuminate\Http\Request;
use Exception;
use App\Models\BuildingModel;

include('ConstFunction.php');


class StageController extends Controller
{
    public function getAllStageData()
    {
        $data = StageModel::all();
        if (count($data) > 0) {
            return messageRequest(1, 'success', $data);
        } else {
            return messageRequest(0, 'Warning', "data is empty");
        }
    }

    public function getStageById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idStage' => 'required|numeric|exists:stage,id',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }
        return messageRequest(1, "success", StageModel::find($request->idStage));
    }

    public function insertStage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_building' => 'required|numeric',
            'stage_name' => 'required|string',
            'stage_number' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }
        // Check Building
        if ($this->checkBuilding($request->id_building)) {
            return messageRequest(-1, "error", "Building does not exist.");
        }

        //Check Stage
        if ($this->checkStage($request->id_building, $request->stage_name, $request->stage_number)) {
            return messageRequest(-1, "error", "The stage already exists");
        }

        $stage = new  StageModel();
        $stage->id_building = $request->id_building;
        $stage->stage_name = $request->stage_name;
        $stage->stage_number = $request->stage_number;

        try {
            $stage->save();
            return messageRequest(1, 'success', "Add Stage Successfuly");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    public function deleteStage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idStage' => 'required|numeric|exists:stage,id',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }

        try {
            $stage = StageModel::find($request->idStage);
            $stage->delete();
            return messageRequest(1, 'success', "Delete stage Successfuly");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    public function ubdateStage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:stage,id',
            'id_building' => 'nullable|numeric',
            'stage_name' => 'nullable|string',
            'stage_number' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }

        $stage = StageModel::find($request->id);
        if ($request->has('id_building')) {

            if ($this->checkStage($request->id_building, $stage->stage_name, $stage->stage_number)) {
                return messageRequest(-1, "error", "The stage already exists in this building.");
            }
            $stage->id_building = $request->id_building;
        }
        if ($request->has('stage_name')) {
            if ($this->checkStage($stage->id_building, $request->stage_name, $stage->stage_number)) {
                return messageRequest(-1, "error", "The stage already exists");
            }
            $stage->stage_name = $request->stage_name;
        }
        if ($request->has('stage_number')) {
            if ($this->checkStage($stage->id_building, $stage->stage_name, $request->stage_number)) {
                return messageRequest(-1, "error", "The stage number already exists");
            }
            $stage->stage_number = $request->stage_number;
        }
        try {
            $stage->save();
            return messageRequest(1, 'success', "Stage updated successfully");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    function checkStage($id_building, $stage_name, $stage_number)
    {
        $stage = StageModel::where('id_building', $id_building)->where('stage_name', $stage_name)->where('stage_number', $stage_number)->first();
        if ($stage) {
            return true;
        }
        return false;
    }

    function checkBuilding($id_building)
    {
        $building = BuildingModel::find($id_building);
        if (!$building) {
            return true;
        }
        return false;
    }
}
