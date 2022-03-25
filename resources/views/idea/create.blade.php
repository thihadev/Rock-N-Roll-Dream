@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
@stop
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Idea</div>
                <div class="card-body">
                            @if ($message = Session::get('error'))
                    <div class="alert alert-danger mt-3 alert-flash">
                        <span>{{ $message }}</span>
                    </div>
                @endif
                    <form method="post" action="{{ route('ideas.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="category_id" class="col-md-4 col-form-label text-md-end">{{ __('Category') }}</label>

                            <div class="col-md-6">
                                <select id="category_id" type="text" class="form-control @error('category_id') is-invalid @enderror" name="category_id" value="{{ old('category_id') }}" required autocomplete="category_id" autofocus>
                                    <option value="">Select One</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->description}}</option>
                                    @endforeach
    
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="department_id" class="col-md-4 col-form-label text-md-end">{{ __('Department') }}</label>

                            <div class="col-md-6">
                                <select id="department_id" type="text" class="form-control @error('department_id') is-invalid @enderror" name="department_id" value="{{ old('department_id') }}" required autocomplete="department_id" autofocus>
                                    <option value="">Select One</option>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}">{{$department->description}}</option>
                                    @endforeach
    
                                </select>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="academic_year_id" class="col-md-4 col-form-label text-md-end">{{ __('Academic Year') }}</label>

                            <div class="col-md-6">
                                <select id="academic_year_id" type="text" class="form-control @error('academic_year_id') is-invalid @enderror" name="academic_year_id" value="{{ old('academic_year_id') }}" required autocomplete="academic_year_id" autofocus>
                                    <option value="">Select One</option>
                                    @foreach($academic_years as $year)
                                        <option value="{{$year->id}}">{{$year->academic_year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row closure_date">
                            <label for="closure_date" class="col-md-3 col-form-label text-md-end">{{ __('Closure Date') }}</label>
                            <input type="hidden" name="closure_date" value="">
                            <label class="col-md-3 col-form-label text-md-end" id="closure_date"></label>
                                            

                            <label for="final_closure_date" class="col-md-3 col-form-label text-md-end">{{ __('Final Closure Date') }}</label>
                            <label class="col-md-3 col-form-label text-md-end" id="final_closure_date"></label>
                        </div>



                        <div class="form-group">
                            <label class="label">Title </label>
                            <input type="text" name="title" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label class="label">Description </label>
                            <textarea name="description" rows="10" cols="30" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="label">Document </label>
                            <input type="file" name="document_url" class="form-control"/>
                        </div>


                        <div class="row">
                            <div class="form-group ml-4">
                                <div class="form-check">
                                    
                                <input type="checkbox" name="annonymous" value="1" class="form-check-input"/>
                                <label for="annonymous" class="form-check-label">{{ __('Anonymous') }}</label>
                                </div>

                            </div>


                            <div class="form-group ml-4">
                                <div class="form-check">
                                    
                                <input type="checkbox" name="term" id="term" class="form-check-input"/>
                                <label for="term" class="form-check-label">{{ __('Terms & Conditions') }}</label>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success save" disabled />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.closure_date').hide();
      $('#academic_year_id').on('change', function(e){
        var academic_year_id = $(this).val();

        var url = '{{ route("get-closure-date") }}';

          $.ajax({
                url: url, 
                type: 'POST',
                dataType: "json", 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id : academic_year_id,
                }
                ,
                success: function(response) {
                    if (academic_year_id == "") { 
                        $('.closure_date').hide();
                    }else{
                        $('.closure_date').show();
                    }
                    $('#closure_date').text(response.closure_date);
                    $('input[name="closure_date"]').val(response.closure_date);
                    $('#final_closure_date').text(response.final_closure_date);
                    // $('input[name="final_closure_date"]').val(response.final_closure_date);
                    // location.reload();
                }
                
          });
      });

    $('#term').change(function() {
          if(this.checked) {
            $('input[type="submit"]').removeAttr('disabled');
          }else{
            $('input[type="submit"]').attr("disabled", true);
          }
      });
  });
</script>
@stop