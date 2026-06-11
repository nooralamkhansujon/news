@extends('layouts.website')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            
        </div>
        
        <div class="col-12 text-center">
            <img src="{{asset('storage/news_paper_pages/'.$news_paper_page_frame->image)}}"/>
            @if($news_paper_page_frame->details_image)
            <img style="margin-top: 30px;" src="{{asset('storage/news_paper_pages/'.$news_paper_page_frame->details_image)}}"/>
            @endif
        </div>
        
    </div>
</div>

@endsection

@section('footer_script')
<script>
    $(document).ready(function(e) {
        
    }
</script>
@endsection
    