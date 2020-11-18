<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books=Book::all();
        return response()->json([
            'success'=>true,
            'data'=>$books->toArray(),
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'author'=>'required',
            'price'=>'required|integer',
        ]);
        $books=new Book;
        $books->name=$request->name;
        $books->author=$request->author;
        $books->price=$request->price;

        if(auth()->user()->book()->save($books)){
            return response()->json([
                'success'=>true,
                'data'=>$books->toArray(),
            ],200);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Book can not be found',
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book=Book::find($id);
        if(!$book){
            return response()->json([
                'success'=>false,
                'message'=>'Book with id:'.$id.' not found',
            ],400);

        }
        return response()->json([
            'success'=>true,
            'data'=>$book->toArray(),
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book=Book::find($id);
        if(!$book){
            return response()->json([
                'success'=>false,
                'message'=>'Book with id:',$id.'not found',
            ],400);
        }
        $updated=$book->fill($request->all())->save();
        if($updated){
            return response()->json([
                'success'=>true,
                'message'=>'Book updated',
            ],500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book=Book::find($id);

        if(!$book){
            return response()->json([
                'success'=>false,
                'message'=>'Book with id:',$id.'not found',
            ],400);
        }
        if($book->delete()){
            return response()->json([
                'success'=>true,
                'message'=>'Book deleted',
            ],500);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Book not deleted',
            ],500);

        }

        
    }
}
