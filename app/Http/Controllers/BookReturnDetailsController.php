<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookReturnDetails;
use Illuminate\Support\Facades\Validator;


class BookReturnDetailsController extends Controller
{
    public function show()
    {
        return BookReturnDetails::all();
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
