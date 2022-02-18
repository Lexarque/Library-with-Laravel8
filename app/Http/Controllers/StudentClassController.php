<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentClass;
use Illuminate\Support\Facades\Validator;

class StudentClassController extends Controller
{
    public function show()
    {
        return StudentClass::all();
    }

    public function detail($id)
    {
        if(StudentClass::where('id_student_class', $id)->exists())
        {
            $data_student_class = StudentClass::where('student_class.id_student_class', $id)->get();
            
            return Response()->json($data_student_class);
        
        }else{
            
            return Response()->json(['Message' => 'Not Found']);
        
        }
    }

   public function store(Request $request){
        $validator=Validator::make($request->all(),
        [
            'name_student_class' => 'required',
            'group_student_class' => 'required'
        ]); 
   
    if($validator->fails()){
        return Response() -> json($validator->errors());
    }
    $store = StudentClass::create([
        
        'name_student_class' => $request->name_student_class,
        'group_student_class' => $request->group_student_class
    
    ]);
    
    if($store) {
        
        return Response()->json(['status'=>1]);
    
    }else{
        
        return Response()->json(['status'=>0]);
    
    }
}
    
    public function destroy($id){
        
        $delete_student_class = StudentClass::where('id_student_class', $id)->delete();
        
        if($delete_student_class){
            
            return Response()->json(['status'=>1, 'Message'=>'Sucess']);
        }else{
            
            return Response()->json(['status'=>0, 'Message'=>'Failed']);
        
        }
    }
}
