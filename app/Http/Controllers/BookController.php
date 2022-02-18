<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            
            return Response()->json($data_book);
        }else
        {
            return Response()->json(['Message' => 'Not Found']);
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
            return Response()->json(['status' => 1]);
        }
        else
        {
            return Response()->json(['status' => 0]);
        }
    }

    public function destroy($id) {
    
        $delete = Book::where('id_book', $id)->delete();
        
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
