<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\BookBorrowDetails;
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
            'borrow.id_students')->where('borrow.id_borrow', $id)->get();
            
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
            'id_students' => 'required'
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
            'detail' => 'required'
        ]);

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $current_time = Carbon::now();
        $due_date = Carbon::now()->addDays(7);

        $store = Borrow::create([
            'date_borrow' => $current_time,
            'date_due' => $due_date,
            'id_students' => $request->id_students

        ]);

        for($i = 0; $i < count($request->detail); $i++){
            $borrow_detail = new BookBorrowDetails();
            $borrow_detail->id_borrow = $store->id_borrow;
            $borrow_detail->id_book = $request->detail[$i]['id_book'];
            $borrow_detail->qty = $request->detail[$i]['qty'];
            $borrow_detail->save();
        }

        if($store && $borrow_detail)
        {
            return Response()->json(['status' => 1, 'message' => 'Success']);
        }
        else
        {
            return Response()->json(['status' => 0, 'message' => 'Failed']);
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
