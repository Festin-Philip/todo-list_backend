<?php

namespace App\Http\Controllers\API;


use App\Models\Todo;
use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\API\BaseController as BaseController;

class TodoController extends BaseController
{
    // protected $user;

    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::all()->toQuery()->paginate(4);   

                return response()->json([$todos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'task'=>'required',
            'status'=>'required',
            'email'=>'required|email'
        ]);

        $todo = new Todo([
            'task' => $request->get('task'),
            'status' => $request->get('status'),
            'email' => $request->get('email'),
           
        ]);
        $todo->save();
        return response()->json([$todo]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todo::find($id);
        return view('todos.edit', compact('todo'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'task'=>'required',
            'status'=>'required',
            'email'=>'required|email'
        ]);

        $todo = Todo::find($id);
        $todo->task =  $request->get('task');
        $todo->status = $request->get('status');
        $todo->email = $request->get('email');
       
        $todo->save();
        return response()->json([$todo]);
        //return redirect('/todos')->with('success', 'Todo updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        $todo->delete();

        return response()->json([$todo]);

    }
}
