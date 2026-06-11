@extends('layouts.app')

@section('header_include')
<script src="{{asset('image-map-creator/dist/image-map-creator.bundle.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.6.0/p5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.6.0/addons/p5.dom.js"></script>
<script src="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.3.3/dist/jBox.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.3.3/dist/jBox.all.min.css" rel="stylesheet">
<script>
    var news_paper_image_url = '{{asset('storage/news_paper_pages/'.$news_paper_pages->image)}}';
    var news_paper_image_frame_json = '{!!$news_paper_pages->map_data_json!!}';
</script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('News Paper Edit') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="div-1" style="position: relative;"></div>
                    {{asset('storage/news_paper_pages/'.$news_paper_pages->image)}}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div style="display: none" id="frameContent">
    <label>Select Image</label>
    <img src="" width="200"/>
    <form id="upload-frame-form">
        <input type="file" name="frame-image" id="frame-image" class="form-control" required/>
        <input type="hidden" name="frame-id" id="frame-id" value=""/>
        <button class="btn btn-primary btn-sm" id="upload-frame">Upload</button>
    </form>
</div> --}}

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">News Frame</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="upload-frame-form">
            <div class="form-group">
                <img src="" width="200"/>
                <img src="" width="200" id="frame-preview-image"/><br/>
                <label for="recipient-name" class="col-form-label">Image <span class="text-danger">*</span></label>
                <input type="file" name="frame-image" id="frame-image" class="form-control" required/>
                <input type="hidden" name="frame-id" id="frame-id" value=""/>
            </div>
            <div class="form-group">
                <img src="" width="200" id="details-preview-image" style="display:none;"/><br/>
                <label for="details-image" class="col-form-label">Details Image (Optional)</label>
                <input type="file" name="details-image" id="details-image" class="form-control" accept="image/*"/>
                <small class="form-text text-muted">This image will be shown in addition to the main frame image if uploaded.</small>
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Title</label>
              <input type="text" class="form-control" id="title">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Details</label>
              <textarea class="form-control" id="details"></textarea>
            </div>
            <button class="btn btn-primary" id="upload-frame">Upload & Save</button>
          </form>
        </div>
        
      </div>
    </div>
  </div>
@endsection

@section('footer_include')
<script type="text/javascript">

    let frameUploadOpen;
    let saveMap;

    $(document).ready(function(){
        $('#exampleModal').on('hidden.bs.modal', function (e) {
            imcreator.setTool(selectedTool);
        })

        var frameUpload = new jBox('Modal', {
            title: 'Upload Frame',
            content: $('#frameContent'),
            onClose:function(){
                imcreator.setTool(selectedTool);
            }
        });
        
        let selectedTool = '';

        frameUploadOpen = (area, prevTool) => {
            $('#title').val('');
            $('#details').val('');
            selectedTool = prevTool;
            $('#frame-id').val(area.id)
            // frameUpload.open();
            $('#exampleModal').modal('show');
            imcreator.setTool('ok');
            getFrameData(area.id)
        }

        function getFrameData(frame_id){
            $.ajax({
                url:'{{route('newsPaperPageFrameSingle')}}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}' },
                data:{frame_id:frame_id},
                type:'POST',
                success:function(res)
                {
                    if(res){
                        $('#title').val(res.title);
                        $('#details').val(res.details);
                         if(res.image){
                            $('#frame-preview-image').attr('src', '{{asset('storage/news_paper_pages')}}/' + res.image).show();
                        }
                        if(res.details_image){
                            $('#details-preview-image').attr('src', '{{asset('storage/news_paper_pages')}}/' + res.details_image).show();
                        } else {
                            $('#details-preview-image').hide();
                        }
                    } else {
                        $('#frame-preview-image').hide();
                        $('#details-preview-image').hide();
                    }
                },
                error:function(xhr,rrr,error)
                {
                    alert(error);
                }
            });
        }

        $('#upload-frame-form').submit(function (e) {
            e.preventDefault();
            let frameId = $('#frame-id').val();
            let title = $('#title').val();
            let details = $('#details').val();

            let formData = new FormData();

            let imageField = document.getElementById('frame-image');
            let detailsImageField = document.getElementById('details-image');

            // Check if image is provided
            if (!imageField.files[0]) {
                alert('Image is required');
                return;
            }
            
            formData.append('news_paper_page_id', {{$news_paper_pages->id}});
            formData.append('frame_id', frameId);
            formData.append('title', title);
            formData.append('details', details);
            formData.append('_token', '{{csrf_token()}}');
            formData.append('image', imageField.files[0]);
            if (detailsImageField.files[0]) {
                formData.append('details_image', detailsImageField.files[0]);
            }
            
            $.ajax({
                url:'{{route('news-paper-page-frame.update')}}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}' },
                data:formData,
                type:'POST',
                processData: false,
                contentType: false,
                success:function(res)
                {
                    $('#title').val('');
                    $('#details').val('');
                    $('#frame-image').val('');
                    $('#details-image').val('');
                    $('#frame-preview-image').attr('src', '').hide();
                    $('#details-preview-image').attr('src', '').hide();
                    $('#exampleModal').modal('hide');
                },
                error:function(xhr,rrr,error)
                {
                    alert(error);
                }
            });
        })
        
        $('#frame-image').change(function(e) {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#frame-preview-image').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        $('#details-image').change(function(e) {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#details-preview-image').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                $('#details-preview-image').hide();
            }
        });

        let imcreator = new imageMapCreator("div-1", 1012,1587);

        saveMap = (mapDataJson, mapDataArea) => {

            let data = {
                mapDataJson:mapDataJson,
                mapDataArea:mapDataArea,
                frameId:{{$news_paper_pages->id}}
            }

            $.ajax({
                url:'{{route('news-paper-page.update')}}',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}' },
                data:data,
                type:'POST',
                success:function(res)
                {
                    
                },
                error:function(xhr,rrr,error)
                {
                    alert(error);
                }
            });
        }
    })

</script>
@endsection