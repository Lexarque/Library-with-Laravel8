<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\BookReturn;

class BookReturnController extends Controller
{
    public function show()
    {
        return BookReturn::all();
    }

    public function detail($id)
    {
        if(BookReturn::where('id_book_return', $id)->exists())
        {
            $data_book_return = BookReturn::join('borrow','borrow.id_borrow', 
            'book_return.id_borrow')->where('book_return.id_book_return', $id)->get();
            
            return Response()->json($data_book_return);
        }else
        {
            return Response()->json(['Message' => 'Not Found']);
        }
    }

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'date_return' => 'required',
            'late_fee' => 'required',
            'id_borrow' => 'required'
        ]);
 
            if($validator->fails()) 
            {
                return Response()->json($validator->errors());
            }
            
            $update = BookReturn::where('id_book_return', $id)->update
            ([
                'date_return' => $request->date_return,
                'late_fee' => $request->late_fee,
                'id_borrow' => $request->id_borrow
    
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
            'date_return' => 'required',
            'late_fee' => 'required',
            'id_borrow' => 'required'
        ]
        );
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $store = BookReturn::create([
            
            'date_return' => $request->date_return,
            'late_fee' => $request->late_fee,
            'id_borrow' => $request->id_borrow

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
    
        $delete = BookReturn::where('id_book_return', $id)->delete();
        
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
