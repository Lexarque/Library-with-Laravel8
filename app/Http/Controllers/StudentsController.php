<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    public function show()
    {   
        return Students::all();
    }

    public function detail($id)
    {
        if(Students::where('$id_students', $id)->exists())
        {
            $data_students = Students::join('StudentClass','StudentClass.id_student_class', 
            'Students.id_student_class')->where('Students.id_students', $id)->get();
            
            return Response()->json($data_students);
        }else
        {
            return Response()->json(['Message' => 'Not Found']);
        }
    }

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'name_students' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'id_student_class' => 'required'
            ]);
 
            if($validator->fails()) 
            {
                return Response()->json($validator->errors());
            }
            
            $update = Students::where('id_students', $id)->update
            ([
                'name_students' => $request->name_students,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'address' => $request->address,
                'id_student_class' => $request->id_student_class
    
            ]);
            if($update) 
            {
                return Response()->json(['status' => 1]);
            }
            else 
            {
                return Response()->json(['status' => 0]);
            }
        }
    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'name_students' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'id_student_class' => 'required'
        ]
        );
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $store = Students::create([
            'name_students' => $request->name_students,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'id_student_class' => $request->id_student_class

        ]);
        if($store)
        {
            return Response()->json(['status' => 1]);
        }
        else
        {
            return Response()->json(['status' => 0]);
        }
    }

    public function destroy($id) {
    
        $delete = Students::where('id_students', $id)->delete();
        
        if($delete) 
        {
            return Response()->json(['status' => 1]);
        }
        else 
        {
            return Response()->json(['status' => 0]);
        }
    }
}
