@extends('frontend.layouts.main')
	@section('content')
        <div class="content container-fluid">
                <div class="photos_gallery">
                    <div class="list-thumbs">
                        <div id="container" class="grid-layout">
                            <?php $new_added_pic_id = Session::get('new_added_pic_id'); ?>
                            @foreach ($pictures as $key => $picture)
                                <?php $class= $attr= ""; ?>
                                @if($picture->id == $new_added_pic_id)
                                    <?php $class="new_added_image animated flash"; ?>
                                @endif
                                <?php
                                    if($key == 0)
                                     {
                                        $class .= " pageNumber";
                                        $attr = 'data-page="1"';
                                     } 
                                 ?>
                                <div data-href="" class="brick {{$picture->id}} {{$class}} " {{$attr}}>
                                    <div class="overflow">
                                        <div class="img-close" > 
                                            {{Form::open(array('method' => 'DELETE', 'url' => ['img/picture/destroy/'.$picture->id]))}}
                                                <button class="a" type="submit"><i class="fa fa-times"></i></button>
                                            {{Form::close()}}
                                            <div class="clear"></div> 
                                        </div> 
                                        <div class="hover-btns"> 
                                            <a href="#" title="">
                                                <i class="fa fa-download"></i>
                                            </a> 
                                            <a target="_blank" href="{{url('img/edit/'.$picture->id)}}" title="">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a> 
                                            @if(Auth::check())
                                                <a target="_blank" class="img-like-btn" data-img-like="{{url('img/toggleLike/'.$picture->id)}}" title="">
                                                    @if($picture->has('likes'))
                                                        {{$picture->likes()->count()}}
                                                    @else
                                                        0
                                                    @endif
                                                     <i class="fa fa-heart-o"></i>
                                                </a> 
                                            @endif
                                            
                                            <a href="{{url('img/show/'.$picture->id)}}" title="">
                                                <i class="fa fa-eye"></i>
                                            </a> 
                                            <div class="clear"></div> 
                                        </div>
                                    </div>
                                    
                                    <div  class="img" style="background-image: url({{url('content/'.$picture->url_origin)}})">
                                        <div class="view-hover">
                                            <img  src="{{url('content/'.$picture->url_origin)}}" alt="">
                                            <div class="title">
                                                {{$picture->name}}
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            @endforeach
                            <!-- <div class="clearfix"></div> -->
                            {{$pictures->links()}}  
                        </div>
                         
                    </div>
                </div>
        </div>
        <script type="text/javascript" charset="utf-8">
            
        	$('.page').addClass('container-fluid').removeClass('container');
            function pagination_position (parent) {
                var $pagination = $(parent).find('.pagination');
                var pageNumber = $(parent).find('.pagination li.active span').text();
                $(parent).find('.pageNumber').attr('data-page', pageNumber);
                if ($pagination.css('display') !== 'none') {
                    $pagination.insertAfter('.list-thumbs');
                    $pagination.wrap('<div class="text-center"></div>');
                };
            }
            jQuery(document).ready(function($) {
                $('#container').jscroll({
                    padding: 20,
                    nextSelector: ".pagination li:last a",
                    contentSelector: '.brick, .pagination, .pageNumber',
                    pagingSelector: '.pagination',
                    loadingHtml: '<div class="load">{{ HTML::image("img/load.gif") }}</div>',
                    callback : function (el) {
                        $(window).trigger("resize");
                        $(this).fadeIn(500);
                        pagination_position(this);
                        // var url = window.location.origin + window.location.pathname
                        var url = window.location.origin + window.location.pathname
                        var search = "?";
                        if(window.location.search && window.location.search.indexOf("?page") == -1)
                        {
                            search = window.location.search + "&";
                            if (search !== -1) {
                                search = search.replace(/page=(.*)/g, "");
                            };
                        }
                        var pageNumber = $(this).find('.pageNumber').attr('data-page');
                        window.history.pushState({}, '',url + search +'page=' + pageNumber);
                        function getBgImgPath(bg) {
                            return bg.replace(/^(url\(['"]?)/i,"").replace(/['"]?\)$/i,"");
                        }
                        $('.brick').mousemove(function(e) {
                            var bg = $(this).children(".img").css("background-image");
                            $(this).children(".img").children(".view-hover").offset({top:e.pageY+10, left:e.pageX+10}).children("img").attr('src',getBgImgPath(bg) );
                        });

                        $( ".brick .hover-btns ,.brick .img-close" ).hover(function() {
                            $(this).parent().parent().children(".img").children(".view-hover").css("opacity","0")
                        }, function() {
                            $(this).parent().parent().children(".img").children(".view-hover").css("opacity","1")
                        });

                        $(this).find('.img-like-btn').click(function(event) {
                            var like_btn = this;
                             $.ajax({
                               url: $(this).attr('data-img-like'),
                               type: 'GET'
                             })
                             .done(function(result) {
                              console.log(result);
                               if (result.state == "liked") {
                                  $(like_btn).html(result.count+' <i class="fa fa-heart"></i>');
                               } else if(result.state == "unliked"){
                                  $(like_btn).html(result.count+' <i class="fa fa-heart-o"></i>');
                               };
                             })
                             .fail(function() {
                               console.log("like error file:picture.index");
                             })
                        })
                    }
                });
                var wall = new freewall(".list-thumbs");
                wall.reset({
                    selector: '.brick',
                    animate: true,
                    cellW: 200,
                    cellH: 200,
                    onResize: function() {
                        wall.refresh();
                    }
                });
                wall.fitWidth();
                // for scroll bar appear;
                $(window).trigger("resize");

                $(window).scroll(function(event) {
                    var pages = [];
                    $('.pageNumber').each(function(index, el) {
                       if ($(this).visible(true)) {
                            pages.push($(this).attr('data-page'));
                        }; 
                    });
                    var url = window.location.origin + window.location.pathname
                    var pageNumber = Math.min.apply(Math,pages);
                    var search = "?";
                    if(window.location.search && window.location.search.indexOf("?page") == -1)
                        {
                            search = window.location.search + "&";
                            if (search !== -1) {
                                search = search.replace(/page=(.*)/g, "");
                            };
                        }
                        window.history.pushState({}, '',url + search +'page=' + pageNumber);
     
                });
                pagination_position('.list-thumbs');
            }); 

        </script>
	@stop