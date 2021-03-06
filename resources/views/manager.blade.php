@extends('layouts.app')

@section('style')
<link href="{{ asset('css/justifiedGallery.min.css') }}" rel="stylesheet">
<link href="{{ asset('swipebox-master/src/css/swipebox.min.css') }}" rel="stylesheet">

@endsection

@section('script')
<script src="{{ asset('swipebox-master/lib/jquery-2.1.0.min.js')}}"></script>
<script src="{{ asset('js/jquery.justifiedGallery.min.js')}}"></script>
<script src="{{ asset('swipebox-master/src/js/jquery.swipebox.min.js')}}"></script>
<script type="text/javascript">
    $('button.del').on('click', function (e) {
        $ths = $(this);
        $.ajax({
			headers: {
				'X-CSRF-TOKEN': '{!! csrf_token() !!}'
			},
			type: 'POST',
			url: '{{ route('deleteimage')}}',
			data: {filename: $(this).data("image")},
			success: function (data) {
                $ths.html('Đã xóa');
                $ths.attr('class', 'btn btn-success btn-sm text-center m-1');
				console.log(data);
			},
			error: function (e) {
				console.log(e);
			}
	    });      
    });  
    
    $("#public").justifiedGallery({
    rowHeight : 100,
    lastRow : 'nojustify',
    margins : 5,
}).on('jg.complete', function () {
    $('.swipeboxExampleImg').swipebox();
});
    $("#private").justifiedGallery({
    rowHeight : 100,
    lastRow : 'nojustify',
    margins : 5,
}).on('jg.complete', function () {
    $('.swipeboxExampleImg').swipebox();
});
</script>
@endsection

@section('content')
<div class="container">
        <div class="modal fade" id="delete-image-public" tabindex="-1" role="dialog" aria-labelledby="delete-image-publicLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="delete-image-publicLabel">Xóa ảnh công khai:</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="window.location.reload();">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                            @if (!Auth::user()->images->where('private', '=' ,0)->count())
                            <p class="text-center">Không có ảnh</p>
                          @else
                            <ul class="list-group">
                                @foreach (Auth::user()->images->where('private', '=' ,0) as $image)
                                <li class="list-group-item">
                                    <img alt="{{$image->name}}" src="{{$image->small_link}}" width="200"/>
                                    <button type="button" class="btn btn-danger btn-sm text-center m-1 del" data-image="{{$image->name}}">Xóa</button>
                                </li>
                                @endforeach 
                            </ul>
                            @endif
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal" onClick="window.location.reload();">Đóng</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="delete-image-private" tabindex="-1" role="dialog" aria-labelledby="delete-image-publicLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="delete-image-publicLabel">Xóa ảnh riêng tư:</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="window.location.reload();">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                                @if (!Auth::user()->images->where('private', '=' ,1)->count())
                                <p class="text-center">Không có ảnh</p>
                              @else
                                <ul class="list-group">
                                    @foreach (Auth::user()->images->where('private', '=' ,1) as $image)
                                    <li class="list-group-item">
                                        <img alt="{{$image->name}}" src="{{$image->small_link}}" width="200"/>
                                        <button type="button" class="btn btn-danger btn-sm text-center m-1 del" data-image="{{$image->name}}">Xóa</button>
                                    </li>
                                    @endforeach 
                                </ul>
                                @endif
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal" onClick="window.location.reload();">Đóng</button>
                        </div>
                      </div>
                    </div>
                  </div>
    <h2 class="text-center">Ảnh cá nhân</h2>
    <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>[Ảnh công khai] <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#delete-image-public">
                        Quản lí ảnh
                      </button></h3>
                      @if (!Auth::user()->images->where('private', '=' ,0)->count())
                          <p class="text-center">Không có ảnh</p>
                        @else
                        <div id="public" >
                                @foreach (Auth::user()->images->where('private', '=' ,0) as $image)
                                    <a href="{{$image->original_link}}" class="swipeboxExampleImg">
                                        <img alt="{{$image->name}}" src="{{$image->small_link}}"/>
                                    </a>
                                @endforeach                   
                        </div>
                      @endif
                <hr/>
                <h3>[Ảnh riêng tư]
                    <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#delete-image-private">Quản lí ảnh </button>
                </h3>
                @if (!Auth::user()->images->where('private', '=' ,1)->count())
                          <p class="text-center">Không có ảnh</p>
                        @else
                <div id="private" >
                        @foreach (Auth::user()->images->where('private', '=' ,1) as $image)
                            <a href="{{$image->original_link}}" class="swipeboxExampleImg">
                                <img alt="{{$image->name}}" src="{{$image->small_link}}"/>
                            </a>
                        @endforeach                   
                </div>
                @endif
            </div>
        </div>
</div>
@endsection
