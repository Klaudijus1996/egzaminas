@extends('layouts.app')

@section('content')
<div class="row">
<div class="container">
    @if (session('status_success'))
        <p style="width: 25%" class="alert alert-success">{{session('status_success')}}</p>
    @endif
    <a style="margin: 0 0 10px 0" class="btn btn-primary" href="{{route('statuses.create')}}">Create new</a>
</div>
@if (isset($_GET['form']))
@auth
    <div class="col-md-3">
        {{-- ADD FORM --}}
        @if (isset($_GET['form']['add']))
        <form action="{{route('statuses.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label>Pavadinimas: </label>
                <input type="text" name="name" class="form-control">
                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <input type="submit" class="btn btn-primary" value="Submit"></button>
            <a style="float: right" class="btn btn-secondary" href="{{route('statuses.index')}}">Back</a>
        </form>
        {{-- EDIT FORM --}}
        @elseif (isset($_GET['form']['edit']))
        <form action="{{route('statuses.update', $_GET['id'])}}" method="POST">
            @csrf @method("PUT")
            <div class="form-group">
                <label>Pavadinimas: </label>
                <input type="text" name="name" class="form-control" value="{{$_GET['name']}}">
                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <input type="submit" class="btn btn-primary" value="Submit"></button>
            <a style="float: right" class="btn btn-secondary" href="{{route('statuses.index')}}">Back</a>
        </form>
        @endif
    </div>
    <div class="col-md-9">
        <table class="table table-dark">
            <thead class="thead thead-light">
                <tr>
                    <th style="width: 20%">Id</th>
                    <th style="width: 50%">Name</th>
                    @if (Auth::check())
                    @auth
                    <th style="width: 30%">Actions</th> 
                    @endauth
                    @endif
                </tr>
            </thead>
            @foreach ($statuses as $status)
            <tr>
                <td>{{$status->id}}</td>
                <td>{{$status->name}}</td>
                @if (Auth::check())
                @auth
                <td>
                    <form action={{ route('statuses.destroy', $status->id) }} method="POST">
                        <a class="btn btn-secondary" href="{{route('statuses.edit', $status->id)}}">Edit</a>
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
                <th style="width: 20%">Id</th>
                <th style="width: 30%">Name</th>
                @if (Auth::check())
                @auth
                <th style="width: 15%">Actions</th> 
                @endauth
                @endif
            </tr>
        </thead>
        @foreach ($statuses as $status)
        <tr>
            <td>{{$status->id}}</td>
            <td>{{$status->name}}</td>
            @if (Auth::check())
            @auth
            <td>
                <form action={{ route('statuses.destroy', $status->id) }} method="POST">
                    <a class="btn btn-secondary" href="{{route('statuses.edit', $status->id)}}">Edit</a>
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