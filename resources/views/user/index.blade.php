@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
@stop
    
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8 margin-tb">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center mt-5">
                    <h2>Academic Year List</h2>
                </div>
            </div>
            <div class="col-md-12 text-end mt-4">
                <a class="btn btn-primary m-1 float-right" href="{{ route('register-user') }}">Add New User</a>
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
        <table class="table table-bordered mt-4" id="user_list">
            <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Date of birth</th>
                <th>Gender</th>
                <th>Mobile No</th>
                <th>Staff Type</th>
                <th>Role</th>
                <th width="180px">Action</th>
            </tr>
            @foreach ($users as $key => $user)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->department->description }}</td>
                <td>{{ $user->date_of_birth }}</td>
                <td>{{ $user->gender() }}</td>
                <td>{{ $user->mobile_no }}</td>
                <td>{{ $user->staffType() }}</td>
                <td>{{ $user->role() }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{route('users.edit',$user)}}"><span class="fa fa-edit"></span></a>
                    <button type="button" class="btn btn-danger btn-sm open_delete" data-toggle="modal" data-id="{{$user->id}}" data-target="#modal_delete"><span class="fa fa-trash"></span></button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<!-- Add Record  Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New Academic Year</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData" method="POST">
                    @csrf 

                    <div class="form-group">
                        <label for="academic_year">Academic Year </label>
                        <input type="text" class="form-control" name="academic_year" placeholder="Enter Academic Year" required="">
                    </div>                    
                    <div class="form-group">
                        <label for="start_date">Start Date </label>
                        <input type="date" class="form-control" name="start_date" placeholder="Enter Start Date" required="">
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date </label>
                        <input type="date" class="form-control" name="end_date" placeholder="Enter End Date" required="">
                    </div>
                    <div class="form-group">
                        <label for="closure_date">Closure Date </label>
                        <input type="date" class="form-control" name="closure_date" placeholder="Enter Closure Date" required="">
                    </div>
                    <div class="form-group">
                        <label for="final_closure_date">Final Closure Date </label>
                        <input type="date" class="form-control" name="final_closure_date" placeholder="Enter Final Closure Date" required="">
                    </div>

                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success" id="btn_save">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

  <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Academic Year</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="EditformData" method="POST">
                        @csrf
                        @method("PATCH")
                        <input type="hidden" name="id" id="edit-form-id">

                        <div class="form-group">
                            <label for="academic_year">Academic Year </label>
                            <input type="text" class="form-control" name="academic_year" id="academic_year" placeholder="Enter Academic Year" required="">
                        </div>                    
                        <div class="form-group">
                            <label for="start_date">Start Date </label>
                            <input type="date" class="form-control" name="start_date" id="start_date" placeholder="Enter Start Date" required="">
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date </label>
                            <input type="date" class="form-control" name="end_date" id="end_date" placeholder="Enter End Date" required="">
                        </div>
                        <div class="form-group">
                            <label for="closure_date">Closure Date </label>
                            <input type="date" class="form-control" name="closure_date" id="closure_date" placeholder="Enter Closure Date" required="">
                        </div>
                        <div class="form-group">
                            <label for="final_closure_date">Final Closure Date </label>
                            <input type="date" class="form-control" name="final_closure_date" id="final_closure_date" placeholder="Enter Final Closure Date" required="">
                        </div>

                        <hr>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary" id="btn_update">Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="alert_ModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><span class="fa fa-info-circle"></span> Confirmation</h4>
                </div>
                <div class="modal-body">
                    Are you sure want to delete?
                </div>
                <div class="modal-footer">
                    <form id="delete_form" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-primary" id="delete-btn">Yes</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">

$(document).on("click", ".open_delete", function () { 
     var id = $(this).data('id');
     var url = '{{ route("academic-years.destroy", ":id") }}';
     url = url.replace(':id', id);
     $('#delete_form').attr('action', url);
 });

</script>
@endsection