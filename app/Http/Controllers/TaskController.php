<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;



class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->status_id) && $request->status_id !== 0)
            $tasks = \App\Task::where('status_id', $request->status_id)->orderBy('id', 'desc')->get();
        else
            $tasks = \App\Task::orderBy('id', 'desc')->get();
        $statuses = \App\Status::orderBy('name')->get();
        return view('tasks.index', ['tasks' => $tasks, 'statuses' => $statuses]);

        // return view('tasks.index', ['tasks' => \App\Task::orderBy('id', 'desc')->get(), 'statuses' => \App\Status::orderBy('id', 'asc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return redirect('tasks.index', ['form' => ['add' => true]]);
        return redirect()->route('tasks.index', ['form' => ['add' => true]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|max:128|alpha',
            'task_description' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $task = new Task();
        $task->fill($request->all());
        $task->save();
        return redirect()->route('tasks.index')->with('status_success', 'Task was created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return redirect()->route('tasks.index', [
            'form' => ['edit' => true],
            'task_name' => $task->task_name,
            'task_description' => $task->task_description,
            'task_deadline' => $task->add_date,
            'task_id' => $task->id,
            'task_completed_date' => $task->completed_date
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'task_name' => "required|max:128|unique:statuses,name, $task->id",
            'task_description' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $task->fill($request->all());
        $task->save();
        return redirect()->route('tasks.index')->with('status_success', 'Task was edited succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('status_success', 'Task was deleted succesfully');
    }
}
