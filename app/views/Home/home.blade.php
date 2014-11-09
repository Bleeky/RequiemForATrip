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
			@if (strstr($pictures->first()->image, "http://") == false && strstr($pictures->first()->image, "https://") == false)
			{{ HTML::image('ressources/pictures/large/' . $pictures->first()->image, null, array('class'=>'top-img', 'id'=>'daily_img')) }}
            @else
			{{ HTML::image($pictures->first()->image, null, array('class'=>'top-img', 'id'=>'daily_img')) }}
            @endif
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

<div id="author" class="text-center" style="padding-bottom: 13px; padding-top: 13px;">
	<button class="btn-author buttoncolor">Commentaires</button>
</div>

<div class="container" style="padding-top: 13px; padding-bottom: 13px; max-width: 1000px; display: none;" id="comments">
				<div id="disqus_thread"></div>
				<script type="text/javascript">
					var disqus_shortname = 'requiemforatrip';
					var disqus_title = '{{ $pictures->first()->title }}';
	                var disqus_identifier = '{{ $pictures->first()->id }}';
                    var disqus_url = 'http://localhost:8000/picture/' + '{{ $pictures->first()->id }}';
					(function() {
						var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
						dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
						(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
					})();
				</script>
				<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
				<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
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

    $(document).on("click", ".btn-author", function() {
            $('#author').hide();
            $('#comments').fadeIn('slow');
    });

	$.ajax({
		url : '{{ URL::action('HomeController@getLastAndFirst') }}',
		type : 'GET',
		dataType : 'json',
		success : function (result) {
			first = result['first'];
			last = result['last'];
		},
		error : function () {
		    bootbox.alert("Oups. There was a problem while getting images.", function() {});
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
			bootbox.alert("Oups. There was a problem while counting images.", function() {});
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
	function NextSetOfPictures() {
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

	function PreviousSetOfPictures() {
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

	function NextPicture(id) {
		if (id != first && first != null) {
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

	function PreviousPicture(id) {
		if (id != last && last != null)  {
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
				$(this).find('img').toggleClass('imagehovered');
				clearTimeout(b);
			});
			c.on("mouseleave", function () {
				$(this).find('img').toggleClass('imagehovered');
				clearTimeout(b);
			})
		}
	});
</script>

@stop