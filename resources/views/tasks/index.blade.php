@extends('layouts.app')

@section('content')
<div class="row">
<div class="container">
    @if (session('status_success'))
        <p style="width: 25%" class="alert alert-success">{{session('status_success')}}</p>
    @endif
    <a style="margin: 0 0 10px 0" class="btn btn-primary" href="{{route('tasks.create')}}">Create new</a>
    <br>
    <form style="float: right" style="width: 30%" action="{{ route('tasks.index') }}" method="GET">
        <select name="status_id" id="" class="form-control">
            <option value="" selected disabled>Pasirinkite statusa uzduociu filtravimui:</option>
            @foreach ($statuses as $status)
            <option value="{{ $status->id }}"
                @if($status->id == app('request')->input('status_id')) 
                    selected="selected" 
                @endif>{{ $status->name }}</option>
            @endforeach
        </select>
        <br>
        <button style="margin: 0 0 10px 0; float: right" type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@if (isset($_GET['form']))
@auth
    <div class="col-md-3">
        {{-- ADD FORM --}}
        @if (isset($_GET['form']['add']))
        <form action="{{route('tasks.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label>Pavadinimas: </label>
                <input type="text" name="task_name" class="form-control">
                @error('task_name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Aprasymas: </label>
                <textarea style="resize: none" class="form-control" name="task_description" id="mce" cols="20" rows="10"></textarea>
                @error('task_description')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Uzduoties statusas: </label>
                <select name="status_id" id="" class="form-control">
                    <option value="" selected disabled>Choose status:</option>
                    <option value="NULL">-</option>
                    @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Deadline: </label>
                <input type="date" name="add_date" class="form-control"> 
                @error('add_date')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <input type="submit" class="btn btn-primary" value="Submit"></button>
            <a style="float: right" class="btn btn-secondary" href="{{route('tasks.index')}}">Back</a>
        </form>
        {{-- EDIT FORM --}}
        @elseif (isset($_GET['form']['edit']))
        <form action="{{route('tasks.update', $_GET['task_id'])}}" method="POST">
            @csrf @method("PUT")
            <div class="form-group">
                <label>Pavadinimas: </label>
                <input type="text" name="task_name" class="form-control" value="{{$_GET['task_name']}}">
                @error('task_name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Aprasymas: </label>
                <textarea style="resize: none" class="form-control" name="task_description" id="mce" cols="20" rows="10">{{$_GET['task_description']}}</textarea>
                @error('task_description')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Uzduoties statusas: </label>
                <select name="status_id" id="" class="form-control">
                    <option value="" selected disabled>Choose status:</option>
                    <option value="NULL">-</option>
                    @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Deadline: </label>
                <input type="date" name="add_date" class="form-control" value={{isset($_GET['task_deadline']) ? $_GET['task_deadline'] : '-'}}> 
                @error('add_date')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Completed on: </label>
                <input type="date" name="completed_date" class="form-control" value={{isset($_GET['task_completed_date']) ? $_GET['task_completed_date'] : '-'}}> 
                @error('completed_date')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <input type="submit" class="btn btn-primary" value="Submit"></button>
            <a style="float: right" class="btn btn-secondary" href="{{route('tasks.index')}}">Back</a>
        </form>
        @endif
    </div>
    <div class="col-md-9">
        <table class="table table-dark">
            <thead class="thead thead-light">
                <tr>
                    <th>Id</th>
                    <th>Task name</th>
                    <th style="width: 20%">Task description</th>
                    <th>Status ID</th>
                    <th>Complete Until</th>
                    <th>Completed</th>
                    @if (Auth::check())
                    @auth
                    <th style="width: 20%">Actions</th> 
                    @endauth
                    @endif
                </tr>
            </thead>
            @foreach ($tasks as $task)
            <tr>
                <td>{{$task->id}}</td>
                <td>{{$task->task_name}}</td>
                <td>{!! $task->task_description !!}</td>
                <td>{{$task->status['name']}}</td>
                <td>{{$task->add_date}}</td>
                <td style="text-align: center;">{{$task->completed_date !== null ? $task->completed_date : '-'}}</td>
                @if (Auth::check())
                @auth
                <td>
                    <form action={{ route('tasks.destroy', $task->id) }} method="POST">
                        <a class="btn btn-secondary" href="{{route('tasks.edit', $task->id)}}">Edit</a>
                        @csrf @method('delete')
                        <input type="submit" class="btn btn-danger" value="Delete"/>
                    </form>
                </td>
                @endauth
                @endif
            </tr>
            @endforeach    
        </table>
    </div>
@endauth
@else
<div class="col-md-12">
    <table class="table table-dark">
        <thead class="thead thead-light">
            <tr>
                <th>Id</th>
                <th>Task name</th>
                <th style="width: 35%">Task description</th>
                <th>Status ID</th>
                <th>Complete Until</th>
                <th>Completed</th>
                @if (Auth::check())
                @auth
                <th style="width: 15%">Actions</th> 
                @endauth
                @endif
            </tr>
        </thead>
        @foreach ($tasks as $task)
        <tr>
            <td>{{$task->id}}</td>
            <td>{{$task->task_name}}</td>
            <td>{!! $task->task_description !!}</td>
            <td>{{$task->status['name']}}</td>
            <td>{{$task->add_date}}</td>
            <td style="text-align: center;">{{$task->completed_date !== null ? $task->completed_date : '-'}}</td>
            @if (Auth::check())
            @auth
            <td>
                <form action={{ route('tasks.destroy', $task->id) }} method="POST">
                    <a class="btn btn-secondary" href="{{route('tasks.edit', $task->id)}}">Edit</a>
                    @csrf @method('delete')
                    <input type="submit" class="btn btn-danger" value="Delete"/>
                </form>
            </td>
            @endauth
            @endif
        </tr>
        @endforeach    
    </table>
</div>
@endif
</div>

@endsection