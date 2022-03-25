@extends('layouts.app')
@section('styles')
<!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" /> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css')}}">
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-striped">
                <thead>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Created By</th>
                    <th>Action</th>
                </thead>
                <tbody>
                @foreach($ideas as $key => $idea)
                <tr>
                    <td>{{ $key + 1}}</td>
                    <td>{{ $idea->title }}</td>
                    <td>{{ $idea->annonymous == true ? "Anonymous" : $idea->createdByUser()}}</td>
                    <td>
                        <a href="{{ route('ideas.show', $idea->id) }}" class="btn btn-primary">Show Post</a>
                    </td>
                </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection