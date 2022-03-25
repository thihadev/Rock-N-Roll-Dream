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
                    <h2>Category List</h2>
                </div>
            </div>
            <div class="col-md-12 text-end mt-4">
                <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal" data-target="#addModal">
                    <i class="fa fa-plus"></i> Add New Category
                </button>
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
        <table class="table table-bordered mt-4" id="category_list">
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
                    <a class="btn btn-primary btn-sm btn-light category_edit" data-edit="{{$category}}" data-toggle="modal" data-target="#editModal">
                    <span class="fa fa-edit fa-lg text-primary"></span></a>
                    <button type="button" class="btn btn-danger btn-sm open_delete" data-toggle="modal" data-id="{{$category->id}}" data-target="#modal_delete"><span class="fa fa-trash"></span></button>
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
                <h4 class="modal-title">Add New Category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="code">Code: </label>
                        <input type="text" class="form-control" name="code" placeholder="Enter Code" required="">
                    </div>
                    <div class="form-group">
                        <label for="description">Description: </label>

                        <textarea name="description" class="form-control" cols="40" rows="5" placeholder="Enter Description" required=""></textarea>
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
                    <h4 class="modal-title">Edit Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="EditformData" method="POST">
                        @csrf
                        @method("PATCH")
                        <input type="hidden" name="id" id="edit-form-id">
                        <div class="form-group">
                            <label for="code">Code: </label>
                            <input type="text" class="form-control" name="code" id="code" placeholder="Enter Code" required="">
                        </div>
                        <div class="form-group">
                            <label for="description">Description: </label>
                            <!-- <input type="text" class="form-control" name="txtDescription" id="txtDescription" placeholder="Enter Description" required=""> -->
                            <textarea name="description" id="description" class="form-control" cols="40" rows="5" placeholder="Enter Description" required=""></textarea>
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
 $(document).ready(function() {
      $('#formData').on('btn_save', function(e){
        e.preventDefault();
        var url = '{{ route("categories.store") }}';

          $.ajax({
                url: url, 
                type: 'POST', 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formData').serialize(),
                success: function(response) {
                    $("#addModal").modal('hide');
                    $("#formData")[0].reset();
                    $("#category_list").load(window.location + " #category_list");
                }
                
          });
      });
    

      $('.category_edit').on("click",function () {
          var edit_datas = $(this).data('edit');  
          $(".modal-body #edit-form-id").val(edit_datas.id);
          $(".modal-body #code").val(edit_datas.code);
          $(".modal-body #description").val(edit_datas.description);
          // $(".modal-body #btn_save").html("Update");
      });

      $("#btn_update").click(function(e) {

            e.preventDefault();
           let category = $('#edit-form-id').val();
           let url = "{{ route('categories.update', ':category') }}"
           url  = url.replace(':category', category);

            $.ajax({
                url: url,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $("#EditformData").serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated successfully',
                    },4000);
                    window.location.reload();

                    $("#editModal").modal('hide');
                    $("#EditformData")[0].reset();

                }
            });
            
        });

      $(document).on("click", ".open_delete", function () { 
             var id = $(this).data('id');
             var url = '{{ route("categories.destroy", ":id") }}';
             url = url.replace(':id', id);
             $('#delete_form').attr('action', url);
         });
  });
</script>
@endsection