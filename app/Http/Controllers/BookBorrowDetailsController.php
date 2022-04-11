<?php

namespace App\Http\Controllers;

use App\Models\BookBorrowDetails;

class BookBorrowDetailsController extends Controller
{
    public function details($id){
        $detail = BookBorrowDetails::where('id_borrow', $id)->with(['book'])->get();
        if($detail){
            return Response()->json($detail);
        }else {
            return Response()->json(['message'=>'Couldnt find the data']);
        }
    }
}
