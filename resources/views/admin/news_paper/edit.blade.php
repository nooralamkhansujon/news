@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form action="{{route('news-paper.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="date" name="publish_date" value="{{$news_paper->publish_date}}" class="form-control"/>
                        </div>
    
                    </form>

                    <div id="pages">
                        @foreach ($news_paper->newsPaperPages as $news_paper_page)
                            <div class="mb-3">
                                <h6 style="font-weight: bold">Page {{$loop->index + 1}}</h6>
                                <img src="{{asset('storage/news_paper_pages/'.$news_paper_page->image)}}" width="400"/>
                                <a href="{{route('news-paper-page.edit', $news_paper_page->id)}}" class="btn btn-primary">Add Frame</a>
                            </div>
                        @endforeach
                    </div>

                    <h3>Add More Page</h3>
                    <input type="file" id="image" name="image" class="form-control mb-2">
                    <button id="paper-upload" class="btn btn-primary">UPLOAD</button>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('#paper-upload').click(function(){
    let formData = new FormData();

    let imageField = document.getElementById('image');

    formData.append('news_paper_id', {{$news_paper->id}});
    formData.append('_token', '{{csrf_token()}}');
    formData.append('image', imageField.files[0]);

    $('#image').css('border', 'solid 1px black')

    if(imageField.files[0]){
        $('#paper-upload').attr('disabled', 'disabled').text('Uploading Please Wait ...')

        $.ajax({
            url:'{{route('news-paper.page-upload')}}',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}' },
            data:formData,
            type:'POST',
            processData: false,
            contentType: false,
            success:function(res)
            {
                $('#pages').append(
                    '<div class="mb-3">'+
                        '<img src="{{asset('storage/news_paper_pages')}}/'+res.image+'" width="400"/>'+
                        '<a href="{{url('admin/news-paper/edit/news_paper_pages')}}/'+res.id+'" class="btn btn-primary">Add Frame</a>'+
                    '</div>'
                )

                $('#paper-upload').removeAttr('disabled').text('UPLOAD')
                $('#image').val('')
            },
            error:function(xhr,rrr,error)
            {
                alert(error);
            }
        });
    }else{
        $('#image').css('border', 'solid 1px red')
    }

    

    
})
</script>
@endsection
