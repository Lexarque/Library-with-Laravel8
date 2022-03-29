<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

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
            'id_students' => 'required',
            'id_book' => 'required'
            ]);
 
            if($validator->fails()) 
            {
                return Response()->json($validator->errors());
            }

            $current_time = Carbon::now();
            
            $update = Borrow::where('id_borrow', $id)->update
            ([
                'date_borrow' => $current_time,
                'date_due' => $current_time->addDays(7),
                'id_students' => $request->id_students,
                'id_book' => $request->id_book
    
            ]);
            if($update) 
            {
                return Response()->json(['status' => 1, 'data' => $update]);
            }
            else 
            {
                return Response()->json(['status' => 0, 'data'=>$update]);
            }
        }
    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'id_students' => 'required',
            'id_book' => 'required'
        ]
        );
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $current_time = Carbon::now();
        $due_date = Carbon::now()->addDays(7);

        $store = Borrow::create([
            'date_borrow' => $current_time,
            'date_due' => $due_date,
            'id_students' => $request->id_students,
            'id_book' => $request->id_book

        ]);
        if($store)
        {
            return Response()->json(['status' => 1, 'data'=>$store]);
        }
        else
        {
            return Response()->json(['status' => 0, 'data'=>$store]);
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
