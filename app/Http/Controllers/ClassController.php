<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Exception;
use App\Models\BuildingModel;
use App\Models\ClassModel;

include('ConstFunction.php');

class ClassController extends Controller
{
    public function getAllClassData()
    {
        $data = ClassModel::all();
        if (count($data) > 0) {
            return messageRequest(1, 'success', $data);
        } else {
            return messageRequest(0, 'Warning', "data is empty");
        }
    }

    public function getClassById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idClass' => 'required|numeric|exists:class,id',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }
        return messageRequest(1, "success", ClassModel::find($request->idClass));
    }

    public function insertClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_stage' => 'required|numeric',
            'class_code' => 'required|numeric',
            'class_student_count' => 'required|numeric',
            'class_gender' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }

        // //Check Class Code inside Stage
        if ($this->checkCode($request->id_stage, $request->class_code)) {
            return messageRequest(-1, "error", "The Class Code already exists in this Stage.");
        }

        $class = new ClassModel();
        $class->id_stage = $request->id_stage;
        $class->class_code = $request->class_code;
        $class->class_student_count = $request->class_student_count;
        $class->class_gender = $request->class_gender;

        try {
            $class->save();
            return messageRequest(1, 'success', "Add Class Successfuly");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    public function deleteClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idClass' => 'required|numeric|exists:class,id',
        ]);

        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }

        try {
            $class = ClassModel::find($request->idClass);
            $class->delete();
            return messageRequest(1, 'success', "Delete Class Successfuly");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    public function ubdateClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:class,id',
            'id_stage' => 'nullable|numeric',
            'class_code' => 'nullable|numeric',
            'class_student_count' => 'nullable|numeric',
            'class_gender' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return messageRequest(-1, "error", $validator->errors());
        }

        $class = ClassModel::find($request->id);
        if ($request->has('id_stage')) {
            if ($this->checkCode($request->id_stage, $class->class_code)) {
                return messageRequest(-1, "error", "The Class already exists in this Stage.");
            }
            $class->id_stage = $request->id_stage;
        }

        if ($request->has('class_code')) {
            if ($this->checkCode($class->id_stage, $request->class_code)) {
                return messageRequest(-1, "error", "The class Code already exists .");
            }
            $class->class_code = $request->class_code;
        }

        if ($request->has('class_student_count')) {
            $class->class_student_count = $request->class_student_count;
        }
        if ($request->has('class_gender')) {
            $class->class_gender = $request->class_gender;
        }

        try {
            $class->save();
            return messageRequest(1, 'success', "Class updated successfully");
        } catch (Exception $e) {
            return messageRequest(-1, 'Warning', $e);
        }
    }

    function checkCode($id_stage, $class_code)
    {
        $class = ClassModel::where('id_stage', $id_stage)->where('class_code', $class_code)->first();
        if ($class) {
            return true;
        }
        return false;
    }
}
