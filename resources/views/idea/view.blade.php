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
                <div class="card-body">
                    <p><b>{{ $idea->title }} Created By {{ $idea->annonymous == true ? "Anonymous" : $idea->createdByUser()}}</b></p>
                    <p>
                        {{ $idea->description }}
                    </p>
                     @foreach($idea->comments as $comment)
                        <div class="display-comment">
                            <strong>{{ $comment->annonymous == true ? "Anonymous" : $comment->user->full_name }}</strong>
                            <p>{{ $comment->description }}</p>
                        </div>
                    @endforeach
                    <hr />
                    <h4>Add comment</h4>
                    <form method="post" action="{{ route('comment.add') }}">
                        @csrf

                        <div class="form-group">
                            <input type="text" name="comment_body" {{$disable}} class="form-control" />
                            <input type="hidden" name="idea_id" id="idea_id" value="{{ $idea->id }}" />
                        </div>

                        <div class="row">
                            
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" {{$disable}}  value="Add Comment" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button type="button" id="reaction_btn" data-id="1" class="btn btn-{{isset($reaction_up) ? $reaction_up : 'outline-secondary'}}">
                                <i class="fa fa-thumbs-up"></i>
                            </button>
                            <button type="button" id="reaction_btn_1" data-id="2" class="btn btn-{{isset($reaction_down) ? $reaction_down : 'outline-secondary'}}">
                                <i class="fa fa-thumbs-down"></i>
                            </button>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-check">
                                    
                                <input type="checkbox" name="annonymous" value="1" class="form-check-input"/>
                                <label for="annonymous" class="form-check-label">{{ __('Anonymous') }}</label>
                                </div>

                            </div>
                        </div>
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
      $('#reaction_btn,#reaction_btn_1').on('click', function(e){
        e.preventDefault();
        var up_down = $(this).data('id');
        var idea_id = $('#idea_id').val();
        var url = '{{ route("reaction.add") }}';

          $.ajax({
                url: url, 
                type: 'POST',
                dataType: "json", 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id : idea_id,
                    up_down : up_down,
                }
                ,
                success: function(response) {
                    location.reload();
                }
                
          });
      });
  });
</script>
@stop