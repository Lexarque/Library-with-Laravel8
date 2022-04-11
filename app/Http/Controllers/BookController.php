<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Book;

class BookController extends Controller
{
    public function show()
    {
        return Book::all();
    }

    public function detail($id)
    {
        if(Book::where('id_book', $id)->exists())
        {
            $data_book = Book::where('book.id_book', $id)->get();
            
            return Response()->json(['status' => 1, $data_book, 'message' => 'id found']);
        }else
        {
            return Response()->json(['status' => 0,'Message' => 'Not Found']);
        }
    }

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'name_book' => 'required',
            'author_book' => 'required',
            'desc_book' => 'required'
        ]);
 
            if($validator->fails()) 
            {
                return Response()->json($validator->errors());
            }
            
            $update = Book::where('id_book', $id)->update
            ([
                'name_book' => $request->name_book,
                'author_book' => $request->author_book,
                'desc_book' => $request->desc_book
    
            ]);
            if($update) 
            {
                return Response()->json(['status' => 1, 'message' => 'update successful !']);
            }
            else 
            {
                return Response()->json(['status' => 0, 'message' => 'update failed !']);
            }
        }
    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'name_book' => 'required',
            'author_book' => 'required',
            'desc_book' => 'required'
        ]
        );
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $store = Book::create([
            
            'name_book' => $request->name_book,
            'author_book' => $request->author_book,
            'desc_book' => $request->desc_book

        ]);
        if($store)
        {
            return Response()->json(['status' => 1, 'message' => 'add successful']);
        }
        else
        {
            return Response()->json(['status' => 0, 'message' => 'add failed']);
        }
    }

    public function destroy($id) {
    
        $delete = Book::where('id_book', $id)->delete();
        
        if($delete) 
        {
            return Response()->json(['status' => 1, 'message' => 'delete successful !']);
        }
        else 
        {
            return Response()->json(['status' => 0, 'message' => 'delete failed !']);
        }
    }

    public function upload_image($id, Request $req){
        $validator=Validator::make($req->all(),
        [
            'book_cover' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        if($validator->fails()){
            return Response() -> json($validator->errors());
        }

        $imageName = time().".".$req->book_cover->extension();
        $req->book_cover->move(public_path('images'), $imageName);

        $update=DB::table('book')->where('id_book', $id)->update(['image' => $imageName]);

        $data = DB::table('book')->where('id_book', $id)->get();
        
        if($update){
            return Response()->json([
                'status' => 1,
                'message' => 'Success upload book cover!',
                'data' => $data
            ]);
        }else{
            return Response()->json([
                'status' => 0,
                'message' => 'Failed upload book cover',
            ]);
        }
    }
}
