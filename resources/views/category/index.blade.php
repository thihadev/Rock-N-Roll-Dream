@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8 margin-tb">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center mt-5">
                    <h2>Category List</h2>
                </div>
            </div>
            <div class="col-md-12 text-end mt-4">
                <a class="btn btn-primary" href="{{ route('categories.create') }}"> + Create New Category</a>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-8 margin-tb">
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-3 alert-flash">
                <span>{{ $message }}</span>
            </div>
        @endif
        <table class="table table-bordered mt-4">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Description</th>
                <th width="180px">Action</th>
            </tr>
            @foreach ($categories as $key => $category)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $category->code }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
       
                        <a class="btn btn-info btn-sm text-white" href="{{ route('categories.show',$category->id) }}">Show</a>
        
                        <a class="btn btn-primary btn-sm" href="{{ route('categories.edit',$category->id) }}">Edit</a>
       
                        @csrf
                        @method('DELETE')
          
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection