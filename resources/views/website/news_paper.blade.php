@extends('layouts.website')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            
        </div>
        
        <div class="col-12">
            <div class="news-paper-date-container">
                <h3>@if ($news_paper){{date('D d, M Y', strtotime($news_paper->publish_date))}}@else Not Found @endif</h3>
                <form action="">
                    <input type="date" class="form-control" max="{{date('Y-m-d')}}" id="paper-date"/>
                </form>
                
                
            </div>
        </div>
        @if ($news_paper)
        <div class="col-md-2">
            <div class="news-paper-pages-container">
                <h3>Pages</h3>
                <div class="news-paper-pages-flex">
                    @foreach ($news_paper->newsPaperPages as $pages)
                    <div class="news-paper-pages">
                        <p>Page {{$loop->index+1}}</p>
                        <img src="{{asset('storage/news_paper_pages/'.$pages->image)}}" class="pages" data-id="{{$pages->id}}" width="100%"/>
                    </div>
                    @endforeach
                </div>
                
            </div>
        </div>

        <div class="col-md-10" style="position: relative;">
            @if(!$news_paper->newsPaperPages->isEmpty())
            <img class="img-fluid" src="{{asset('storage/news_paper_pages/'.$news_paper->newsPaperPages[0]->image)}}" id="mapimage" usemap="#90789789"/>
            <div id="canvas-loader" style="
                display: none!important;
                position: absolute;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: rgba(255,255,255,0.5);
                z-index: 999;
                display: flex;
                justify-content: center;
                align-items: center;
            ">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            @endif
        </div>
        @endif
        
        
    </div>
</div>

@if ($news_paper)
<div id="map-area">
    @if(!$news_paper->newsPaperPages->isEmpty())
    {!!$news_paper->newsPaperPages[0]->map_data_area!!}
    @endif
</div>
@endif


<div class="modal fade" id="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Page Frame</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="/images/footer-logo.jpg" class="img-fluid"/>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                            Image 
                            <i class="fas fa-search-plus" id="zoom-in-frame-image" style="margin: 0 0px 0 10px; font-size: 16px"></i>
                            <i class="fas fa-search-minus" id="zoom-out-frame-image" style="margin: 0 0px 0 10px; font-size: 16px"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" id="frame-fb-share" class="btn btn-default"><i class="fab fa-facebook-f"></i> Share on Facebook</a>
                    </li>
                    <li class="nav-item" id="text-button">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Text</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent" style="overflow: scroll;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div id="frame-image"></div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <p id="frame-text"></p>
                    </div>
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button class="fa-solid fa-left-right" id="resize"></button>
            </div>
            
        </div>
    </div>
</div>

@endsection

@section('footer_script')
<script>
function checkFramesAndHighlight(news_paper_page_id) {
        if(!news_paper_page_id) {
            // Get page id from current page
            let currentPage = $('.pages.active').data('id') || $('.pages').first().data('id');
            if(!currentPage) return;
            news_paper_page_id = currentPage;
        }
        
        // Get all frames for this page at once
        $.post('/news-paper-page_frames', {
            news_paper_page_id: news_paper_page_id,
            _token: '{{ csrf_token() }}'
        }, function(frames){
            let framesWithImages = {};
            debugger
            // Build a map of frames that have images
            if(frames) {
                Object.keys(frames).forEach(function(uniqueId) {
                    if(frames[uniqueId].image) {
                        framesWithImages[uniqueId] = true;
                    }
                });
            }
            
            // Apply highlighting based on whether frame has image
            $('#map-area area').each(function() {
                let frame_id = $(this).attr('id');
                let $area = $(this);
                
                if(framesWithImages[frame_id]) {
                    // Frame has image, enable highlighting
                    $area.data('maphilight', {
                        fill: true,
                        fillColor: '000000',
                        fillOpacity: 0.2,
                        stroke: true,
                        strokeColor: 'ff0000',
                        strokeOpacity: 0.8,
                        strokeWidth: 2
                    }).trigger('alwaysOn.maphilight');
                    $area.css('cursor', 'pointer');
                } else {
                    // Frame doesn't have image, disable highlighting
                    $area.data('maphilight', {
                        fill: false,
                        stroke: false
                    });
                    $area.css('cursor', 'default');
                }
            });
            
            // Reapply maphilight after checking all frames
            setTimeout(function() {
                $img.maphilight();
            }, 100);
        }).fail(function() {
            // If endpoint fails, disable all highlighting
            $('#map-area area').each(function() {
                $(this).data('maphilight', {
                    fill: false,
                    stroke: false
                });
                $(this).css('cursor', 'default');
            });
        });
    }
    $(document).ready(function(e) {
        $('img[usemap]').rwdImageMaps();
        $('img[usemap]').maphilight();

        @if ($news_paper && !$news_paper->newsPaperPages->isEmpty())
            let initialPageId = {{$news_paper->newsPaperPages[0]->id}};
            checkFramesAndHighlight(initialPageId);
        @endif
        
        $('.pages').click(function(){
            debugger
            let news_paper_page_id = $(this).data('id');
             $('#canvas-loader').show();
            $.post('{{route('newsPaperPageSingle')}}', {
                news_paper_page_id: news_paper_page_id,
                _token: '{{ csrf_token() }}'
            })
            .done(function(res){
                let image = res.image;
                let map_data_area = res.map_data_area;
        
                // Replace map HTML
                $('#map-area').html(map_data_area);
        
                // Destroy old maphilight
                let $img = $('#mapimage');
                $img.data('maphilight', null);        // remove plugin data
                $img.next('canvas').remove();         // remove old overlay
                $img.off('load');                     // remove old load events
        
                // Update src with cache-busting
                $img.attr('src', '{{asset('storage/news_paper_pages')}}/' + image + '?t=' + new Date().getTime())
                    .css('opacity', 1);               // restore visible
        
                // Re-initialize after image loads
                $img.on('load', function(){
                    $img.rwdImageMaps();
                    $img.maphilight({fade:false});
                    checkFramesAndHighlight(news_paper_page_id);
                    $('#canvas-loader').hide();
                });
            })
            .fail(function(xhr){
                console.error("Failed:", xhr.responseText);
                $('#canvas-loader').hide();
            });
            
            // $.post('{{route('newsPaperPageSingle')}}', {news_paper_page_id:news_paper_page_id,_token:'{{ csrf_token() }}'}, function(res){
            //     let image = res.image;
            //     let map_data_area = res.map_data_area;

            //     $('#mapimage').attr('src','{{asset('storage/news_paper_pages')}}/'+image);
            //     $('#map-area').html(map_data_area);

            //     $('img[usemap]').rwdImageMaps();
            //     $('img[usemap]').maphilight();

            // });
        })

        $('#map-area').on('click', 'area',function() {
            let frame_id = $(this).attr('id');
            $('.modal-title').html('');
            $('#text-button').hide();
            $.post('{{route('newsPaperPageFrameSingle')}}', {frame_id:frame_id,_token:'{{ csrf_token() }}'}, function(res){
                if(!res) {
                    return;
                }
                $('#frame-image').html('<img class="img-fluid" src="{{asset('storage/news_paper_pages')}}/'+res.image+'"/>');
                if(res.details_image) {
                        $('#frame-details-image').html('<img class="img-fluid" src="{{asset('storage/news_paper_pages')}}/'+res.details_image+'"/>');
                    }
                $('#frame-text').html(res.details);
                if(res.title && res.title!=''){
                    $('#text-button').show();
                }
                $('#frame-fb-share').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=https://epaper.amarbanglabd.com/news-paper-frame/'+res.unique_id);
                $('.modal-title').html(res.title);
                $('#modal').modal('show');
            });
        });

        $('#paper-date').change(function(){
            let date = $(this).val();

            window.location.href = "{{url('/')}}/"+date+'/paper';
        })

        $('#zoom-in-frame-image').click(function(){
            $('#frame-image img').removeClass('img-fluid')
        })

        $('#zoom-out-frame-image').click(function(){
            $('#frame-image img').addClass('img-fluid')
        })

        if($(window).width()>767){
            setInterval(() => {
                $('.news-paper-pages-flex').height($('#mapimage').height());
            }, 1000);
        }
        
        let resize = false
        
        let on_click_screen_x;
        $('#resize').mousedown(function(){
            console.log('up')
            resize = true
            on_click_screen_x = screen_x
        })
        
        $('#resize').mouseup(function(){
            console.log('down')
            resize = false
            $(this).css({
                'position':'initial'
            })
        })
        
        let screen_x;
        let modal_width = 500;
        
        $(window).mousemove(function(e){
            screen_x = e.screenX
            console.log(e.clientX, e.clientY, resize)
            if(resize){
                modal_width = 500 + (e.screenX - on_click_screen_x)
                console.log(modal_width)
                $('#resize').css({
                    'position':'fixed',
                    'left': e.clientX - 20,
                    'top': e.clientY - 10
                })
                
                $('.modal-dialog').css('max-width', modal_width)
            }
        })
    });
</script>
@endsection
    