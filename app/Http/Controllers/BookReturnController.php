<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\BookReturn;
use Illuminate\Support\Carbon;

class BookReturnController extends Controller
{
    public function show()
    {
        $data = DB::table('book_return')->join('borrow','borrow.id_borrow', 
        'book_return.id_borrow')->get();
        if($data->isEmpty()){
            return response()->json([
                'status' => 0,
                'message' => 'Book Return table is empty'
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
        if(BookReturn::where('id_book_return', $id)->exists())
        {
            $data_book_return = BookReturn::join('borrow','borrow.id_borrow', 
            'book_return.id_borrow')->where('book_return.id_book_return', $id)->get();
            
            return Response()->json(['status' => 1, 'data' => $data_book_return], 200);
        }else
        {
            return Response()->json(['status' => '0', 'Message' => 'Not Found'], 404);
        }
    }

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'id_borrow' => 'required'
        ]);
 
        if($validator->fails()){
                return Response()->json($validator->errors());
        }

        $fee = 6500;
        $current_time = Carbon::now()->format('Y-m-d');
        $due_date = DB::table('borrow')->select('date_due')->where('id_borrow', $request->id_borrow)->first();
        
        //test if date is late
        // update: IT WORKS LET'S GOOOOOOOOOOOOOOOOOOOOO
        // $date_dummy = Carbon::create($due_date->date_due);

        //converting date into objects
        $date_now = Carbon::create($current_time);
        $date_due = Carbon::create($due_date->date_due);
        if($date_now->gt($date_due)){
            $late_fee = $fee * ($date_now->diffInDays($date_due));
        }else{
            $late_fee = 0;
        }
            $update = BookReturn::where('id_book_return', $id)->update([
                'date_return' => $date_now,
                'late_fee' => $late_fee,
                'id_borrow' => $request->id_borrow
            ]);
            
            if($update) 
            {
                return Response()->json(['status' => 1, 'data' => $update], 200);
            }
            else 
            {
                return Response()->json(['status' => 0, 'Message' => 'Not Found'], 404);
            }
        }
    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'id_borrow' => 'required'
        ]
        );
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $fee = 6500;
        $current_time = Carbon::now()->format('Y-m-d');
        $due_date = DB::table('borrow')->select('date_due')->where('id_borrow', $request->id_borrow)->first();
        
        // test if date > due date
        // update: IT WORKS LET'S GOOOOOOOOOOOOOOOOOOOOO
        // $date_dummy = Carbon::create($due_date->date_due);

        //converting date into objects
        $date_now = Carbon::create($current_time);
        $date_due = Carbon::create($due_date->date_due);
        if($date_now->gt($date_due)){
            $late_fee = $fee * ($date_now->diffInDays($date_due));
        }else{
            $late_fee = 0;
        }

        $store = BookReturn::create([
            
            'date_return' => $date_now,
            'late_fee' => $late_fee,
            'id_borrow' => $request->id_borrow

        ]);
        if($store)
        {
            return Response()->json(['status' => 1, 'data' => $store], 200);
        }
        else
        {
            return Response()->json(['status' => 0, 'data' => $store]);
        }
    }

    public function destroy($id) {
    
        $delete = BookReturn::where('id_book_return', $id)->delete();
        
        if($delete) 
        {
            return Response()->json(['status' => 1, 'Message' => 'Successfully deleted'], 200);
        }
        else 
        {
            return Response()->json(['status' => 0, 'Message' => 'Deletion Failed']);
        }
    }
}
