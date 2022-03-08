<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use Illuminate\Support\Facades\Validator;

class BorrowController extends Controller
{
    public function show()
    {
        return Borrow::all();
    }

    public function detail($id)
    {
        if(Borrow::where('id_borrow', $id)->exists())
        {
            $data_Borrow = Borrow::join('students','students.id_students', 
            'borrow.id_students')->join('book', 'book.book_name', 'borrow.book_name')->where('borrow.id_borrow', $id)->get();
            
            return Response()->json($data_Borrow);
        }else
        {
            return Response()->json(['Message' => 'Not Found']);
        }
    }

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'date_borrow' => 'required',
            'id_students' => 'required',
            'id_book' => 'required'
            ]);
 
            if($validator->fails()) 
            {
                return Response()->json($validator->errors());
            }
            
            $update = Borrow::where('id_borrow', $id)->update
            ([
                'date_borrow' => $request->date_borrow,
                'id_students' => $request->id_students,
                'id_book' => $request->id_book
    
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
            'date_borrow' => 'required',
            'id_students' => 'required',
            'id_book' => 'required'
        ]
        );
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $store = Borrow::create([
            'date_borrow' => $request->date_borrow,
            'id_students' => $request->id_students,
            'id_book' => $request->id_book

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
    
        $delete = Borrow::where('id_borrow', $id)->delete();
        
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
