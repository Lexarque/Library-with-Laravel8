<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    public function show()
    {   
        $data = DB::table('students')->join('student_class','student_class.id_student_class', 
        'students.id_student_class')->select('students.*', 'student_class.*')->get();
        if($data->isEmpty()){
            return response()->json([
                'status' => 0,
                'message' => 'Students table is empty'
                ], 404);
        }else{
            return Response()->json([
                'status' => 1,
                'data' => $data
                ], 200);
        }
    }

    public function detail($id)
    {
        if(Students::where('id_students', $id)->exists())
        {
            $data_students = Students::join('student_class','student_class.id_student_class', 
            'students.id_student_class')->where('students.id_students', $id)->get();
            
            return Response()->json(['status' => 1, 'data' => $data_students]);
        }else
        {
            return Response()->json(['status' => 1, 'Message' => 'Not Found']);
        }
    }

    public function search_by_name($name){
        if(Students::where('name_students', 'like', '%'.$name.'%')->exists()){
            
            $data = DB::table('students')->join('student_class','student_class.id_student_class', 
            'students.id_student_class')->select('students.*', 'student_class.*')->where('name_students', 'like', '%'.$name.'%')->get();
            
            return Response()->json(['status' => 1, 'data' => $data]);
        }else{
            return Response()->json(['status' => 0, 'Message' => 'Not Found']);
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
            return Response()->json(['status' => 1, 'message' => 'Successfully deleted']);
        }
        else 
        {
            return Response()->json(['status' => 0, 'message' => 'Failed to delete']);
        }
    }

    public function upload_image($id, Request $req){
        
        $validator=Validator::make($req->all(),
        [
            'photo_students' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        if($validator->fails()){
            return Response() -> json($validator->errors());
        }

        $imageName = time().".".$req->photo_students->extension();
        $req->photo_students->move(public_path('images'), $imageName);

        $update=DB::table('students')->where('id_students', $id)->update(['photo_students' => $imageName]);

        $data = DB::table('students')->where('id_students', $id)->get();
        
        if($update){
            return Response()->json([
                'status' => 1,
                'message' => 'Success upload student photo!',
                'data' => $data
            ]);
        }else{
            return Response()->json([
                'status' => 0,
                'message' => 'Failed upload student photo',
            ]);
        }
    }
}
