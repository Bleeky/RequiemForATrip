var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ? true : false;

$(document).ready(function() {
	if (!isMobile) {
		$('.tooltipdefault').tooltipster({
			animation: 'fade',
			arrow: 1,
			timer: 5000,
			offsetY: 10,
			delay: 500,
            speed: 200,
			theme: 'tooltipster-shadow'
		});
	}
});

jQuery("document").ready(function ($) {
	if (!isMobile) {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 300) {
				$("#nav-containerfix").css("visibility", "visible");
				$("#nav-container").css("visibility", "hidden");
			}
			else {
				$("#nav-container").css("visibility", "visible");
				$("#nav-containerfix").css("visibility", "hidden");
			}
		});
	}
});

function isValidEmailAddress(b) {
	var a = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
	return a.test(b)
}

$(function () {
	$("#formcontact").submit(function (a) {
		var b = $(this);
		if (!isValidEmailAddress($("#email").val())) {
            $('#email').addClass("redborder");
			$("#button-blue").attr("disabled", false);
			return false
		}
        else
            $('#email').removeClass("redborder");
        if ($('#name').val().length < 3 ) {
            $('#name').addClass("redborder");
            $("#button-blue").attr("disabled", false);
            return false
        }
        else
            $('#name').removeClass("redborder");
        if ($('#message').val().length < 1 ) {
            $('#message').addClass("redborder");
            $("#button-blue").attr("disabled", false);
            return false
        }
        else
            $('#message').removeClass("redborder");
		a.preventDefault();
		$(this).fadeOut(function () {
			$("#loading").fadeIn(function () {
				$.ajax({
					type: "POST",
					url: b.attr("action"),
					data: b.serialize(),
					success: function (e) {
						$("#loading").fadeOut(function () {
							$("#success").text(e).fadeIn('slow')
						});
					},
					error: function (xhr, ajaxOptions, thrownError) {
						$("#loading").fadeOut(function () {
							$("#success").text(thrownError).fadeIn('slow')
						});
					}
				})
			})
		})
	})
});