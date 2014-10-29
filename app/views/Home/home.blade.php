@extends('Layouts.default')
@section('content')

<div class="page-container">


        <div class="text-center separator">
            <div class="separator-text">Le cliché du moment</div>
        </div>

<div class="container" id="recent_daily" style="padding-top: 13px;">
	<div class="row">
		<div class="text-center">
			<div class="switchbutton">
				<div class="left" style="margin-right: 10px;">
					<button id="morerecent" style="visibility: hidden;" class="btn-circle-large btn-dailys buttoncolor" onclick="PreviousPicture({{ $pictures->first()->id }});"><i class="fa fa-arrow-left"></i></button>
				</div>
			</div>
			{{ HTML::image('ressources/pictures/large/' . $pictures->first()->image, null, array('class'=>'img-responsive img-thumbnail top-img', 'id'=>'daily_img')) }}
			<div class="switchbutton">
				<div class="right" style="margin-left: 10px;">
					<button id="lessrecent" class="btn-circle-large btn-dailys buttoncolor" onclick="NextPicture({{ $pictures->first()->id }});"><i class="fa fa-arrow-right"></i></button>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2">
			<div class="daily-comment text-center">
				<h3 id="title">{{ $pictures->first()->title }}</h3>
				<p id="comment">{{ $pictures->first()->content }}</p>
			</div>
		</div>
	</div>
</div>
        <div class="text-center separator">
            <div class="separator-text">Plus de clichés</div>
        </div>
	<div class="container">
        <div class="left" style="margin-left: 10px;">
            <button id="morerecentset" class="btn-circle-large btn-dailys buttoncolor" onclick="PreviousSetOfPictures();"><i class="fa fa-arrow-left"></i></button>
        </div>
        <div class="right" style="margin-right: 10px;">
            <button id="lessrecentset" class="btn-circle-large btn-dailys buttoncolor" onclick="NextSetOfPictures();"><i class="fa fa-arrow-right"></i></button>
        </div>
	</div>

<div class="container" style="padding-top: 26px; padding-bottom: 13px;">
    @include('Home.Picture.setOfPictures')
</div>

</div>

<script type="text/javascript">

	$.ajax({
		url : '{{ URL::action('HomeController@getLastAndFirst') }}',
		type : 'GET',
		dataType : 'json',
		success : function (result) {
			first = result['first'];
			last = result['last'];
		},
		error : function () {
			alert("Error : could not get first and last picture.");
		}
	});
	$.ajax({
		url : '{{ URL::action('HomeController@getPictureTotal') }}',
		type : 'GET',
		dataType : 'json',
		success : function (result) {
			total = result['total'];
		},
		error : function () {
			alert("Error : could not count pictures.");
		}
	});

	function RequestRefresh(id) {
		$.ajax({
			url: '{{ URL::action('HomeController@getSelectedPicture') . '/' }}' + id,
			type: 'GET',
			dataType: 'html',
			success : function(code_html, statut){
				$(code_html).replaceAll("#recent_daily").hide().fadeIn("slow");
				$("html, body").animate({scrollTop: 300}, 1000);
			}
		});
	}

	var offset = 0;
	function NextSetOfPictures()
	{
		offset = NextOffset(offset);
		$.ajax({
			url: '{{ URL::action('HomeController@getSetOfPictures') . '/' }}' + offset,
			type: 'GET',
			dataType: 'html',
			success : function(code_html, statut){
				$(code_html).replaceAll("#alldailys").hide().fadeIn("slow");
                if (!isMobile) {
                            var a = $(".container"),
                            c = a.children("article"),
                            b;
                            c.on("mouseenter", function () {
                                $(this).find('img').toggleClass('hovered');
                                clearTimeout(b);
                            });
                            c.on("mouseleave", function () {
                                $(this).find('img').toggleClass('hovered');
                                clearTimeout(b);
                            })
                        }
					}
		});
	}

	function PreviousSetOfPictures()
	{
		offset = PreviousOffset(offset);
		$.ajax({
			url: '{{ URL::action('HomeController@getSetOfPictures') . '/' }}' + offset,
			type: 'GET',
			dataType: 'html',
			success : function(code_html, statut){
				$(code_html).replaceAll("#alldailys").hide().fadeIn("slow");
                if (!isMobile) {
                            var a = $(".container"),
                            c = a.children("article"),
                            b;
                            c.on("mouseenter", function () {
                                $(this).find('img').toggleClass('hovered');
                                clearTimeout(b);
                            });
                            c.on("mouseleave", function () {
                                $(this).find('img').toggleClass('hovered');
                                clearTimeout(b);
                            })
                        }
					}
		});
	}

	function NextOffset(off) {
		if ((off + 8) < total)
			off = off + 8;
		return off
	}
	function PreviousOffset(off) {
		if (off > 0)
			off = off - 8;
		return off
	}

	function NextPicture(id)
	{
		if (id != first && first != null)
		{
			$.ajax({
				url: '{{ URL::action('HomeController@getNextPicture') . '/' }}' + id,
				type: 'GET',
				dataType: 'html',
				success : function(code_html, statut){
					$(code_html).replaceAll("#recent_daily").hide().fadeIn("slow");
				}
			});
		}
		else
			$('#recent_daily').hide().fadeIn("slow");
	}

	function PreviousPicture(id)
	{
		if (id != last && last != null)
		{
			$.ajax({
				url: '{{ URL::action('HomeController@getPreviousPicture') . '/' }}' + id,
				type: 'GET',
				dataType: 'html',
				success : function(code_html, statut){
					$(code_html).replaceAll("#recent_daily").hide().fadeIn("slow");
				}
			});
		}
		else
			$('#recent_daily').hide().fadeIn("slow");
	}

	$(function () {
		if (!isMobile) {
			var a = $(".container"),
			c = a.children("article"),
			b;
			c.on("mouseenter", function () {
				$(this).find('img').toggleClass('hovered');
				clearTimeout(b);
			});
			c.on("mouseleave", function () {
				$(this).find('img').toggleClass('hovered');
				clearTimeout(b);
			})
		}
	});

//	$(function () {
//		if (!isMobile) {
//			var a = $(".container"),
//			c = a.children("article"),
//			b;
//			c.on("mouseenter", function () {
//				var d = $(this);
//				clearTimeout(b);
//				b = setTimeout(function () {
//					if (d.hasClass("active")) {
//						return false
//					}
//					c.not(d).removeClass("active").addClass("blur");
//					d.removeClass("blur").addClass("active")
//				}, 0)
//			});
//			c.on("mouseleave", function () {
//				clearTimeout(b);
//				c.removeClass("active blur")
//			})
//		}
//	});
</script>

@stop