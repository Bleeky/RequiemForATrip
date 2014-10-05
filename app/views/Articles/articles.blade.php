@extends('Layouts.default')
@section('content')

<div class="container" id="newslisting" style="padding-top: 50px;">
	@foreach ($articles as $count => $article)
	@if ($count % 2 == 1)
		<div class='newsbox right'>
	@else
		<div class='newsbox left'>
	@endif
		<div class="boxtitle">
			<a href="{{ URL::action('ArticleController@getContent', array($article->id)) }}" style="text-decoration: none;"><boxtitle>{{ $article->title }}</boxtitle></a>
		</div>
		<div class="boximg">
			<a href="{{ URL::action('ArticleController@getContent', array($article->id)) }}">{{ HTML::image($article->image, null) }}</a>
		</div>
		<div class="boxdate">
			{{ $article->getDate() }}
		</div>
		<br>
		<div class="boxintro">
			{{ str_limit($article->introduction, $limit = 260, $end = ' . . .') }}
		</div>
		<br>
		<div class="boxreader">
			<a href="{{ URL::action('ArticleController@getContent', array($article->id)) }}"><button style="font-size: 13px;" class="btn-author btn-more-6 btn-more-6a">LIRE L'ARTICLE</button></a>
		</div>
		</div>
	@endforeach
</div>
<div id="button_more_articles" class="container text-center" style="padding-bottom: 50px; padding-top: 20px;">
	<button class="btn-more btn-more-6 btn-more-6a" onclick="RequestMoreArticles();">Plus d'articles</button>
</div>

<script type="text/javascript">

var offset_articles = 0;
function RequestMoreArticles() {
	offset_articles = offset_articles + 4;
		if (offset_articles + 4 >= max_articles) {
			$("#button_more_articles").fadeOut("slow");
		}
	$.ajax({
		url: '{{ URL::action('ArticleController@getMoreArticle') . '/' }}' + offset_articles,
		type: 'GET',
		dataType: 'html',
		success : function(code_html, statut){
			$(code_html).appendTo("#newslisting").hide().fadeIn("slow");
			$(".newsbox").on("mouseenter", function () {
				$news = $(this);
				$button = $news.children(".boxreader");
				$img = $news.children(".boximg");
				$button.addClass("hovered", 1000);
				$img.addClass("zoomed", 1000)
			});
			$(".newsbox").on("mouseleave", function () {
				$news = $(this);
				$button = $news.children(".boxreader");
				$img = $news.children(".boximg");
				$button.removeClass("hovered", 1000);
				$img.removeClass("zoomed", 1000)
			})
		}
	});
}

$.ajax({
		url : '{{ URL::action('ArticleController@getArticleTotal') }}',
		type : 'GET',
		dataType : 'json',
		success : function (result) {
			max_articles = result['total'];
			if (offset_articles + 4 >= max_articles)
				$("#button_more_articles").fadeOut();
		},
		error : function () {
			alert("error : could not count articles");
		}
	});

$(".newsbox").on("mouseenter", function () {
	$news = $(this);
	$button = $news.children(".boxreader");
	$img = $news.children(".boximg");
	$button.addClass("hovered", 1000);
	$img.addClass("zoomed", 1000)
});

$(".newsbox").on("mouseleave", function () {
	$news = $(this);
	$button = $news.children(".boxreader");
	$img = $news.children(".boximg");
	$button.removeClass("hovered", 1000);
	$img.removeClass("zoomed", 1000)
});

</script>

@stop