<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookReturnDetails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class BookReturnDetailsController extends Controller
{
    public function show()
    {
        $data = DB::table('return_details')->join('book_return', 'book_return.id_book_return', 'return_details.id_book_return')->join('book', 'book.id_book', 'return_details.id_book')->select('return_details.*', 'book_return.*', 'book.name_book', 'book.author_book')->get();
        if($data->isEmpty()){
            return response()->json([
                'status' => 0,
                'message' => 'BookReturnDetails table is empty'
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
        if(BookReturnDetails::where('id_return_details', $id)->exists())
        {
            $data_return_details = BookReturnDetails::join('book','book.id_book', 
            'return_details.id_book')->join('borrow', 'borrow.id_borrow', 'return_details.id_borrow')->where('return_details.id_return_details', $id)->get();
            
            return Response()->json($data_return_details);
        }else
        {
            return Response()->json(['Message' => 'Not Found']);
        }
    }

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'qty' => 'required',
            'id_book' => 'required',
            'id_borrow' => 'required'
        ]
        );
 
            if($validator->fails()) 
            {
                return Response()->json($validator->errors());
            }
            
            $update = BookReturnDetails::where('id_return_details', $id)->update
            ([
                'qty' => $request->qty,
                'id_book' => $request->id_book,
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
            'qty' => 'required',
            'id_book' => 'required',
            'id_borrow' => 'required'
        ]
        );
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $store = BookReturnDetails::create([
            'qty' => $request->qty,
            'id_book' => $request->id_book,
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
    
        $delete = BookReturnDetails::where('id_return_details', $id)->delete();
        
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
