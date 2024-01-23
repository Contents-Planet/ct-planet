var tag = document.createElement('script');
tag.src = "//www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var __team = ND.RETURN.param("team");

$(function() {
	if(location.hash) {
		var arry = location.hash.split("="),
			sec = arry[1];
		GNB.ScrollSec(sec)
	}

	Common.Init();
	Motion.Init();
	GNB.Init();
	Reference.Init();
})

$.fn.scrollStopped = function(callback) {
	var that = this, $this = $(that);
	$this.scroll(function(ev) {
		clearTimeout($this.data('scrollTimeout'));
		$this.data('scrollTimeout', setTimeout(callback.bind(that), 100, ev));
	});
};

var Common = {
	/**
	 * youtube interaction
	 */
	youtubePlay : function(container, sid, youtube) {
		$("[data-selector="+ container +"]").find("[data-selector=videoFrame]").remove();
		var $playWrap ='<div class="iframe" id="iframe-wrap'+ sid +'" data-selector="videoFrame"></div>';
		$("[data-selector="+ container +"]").append($playWrap);

		var player = new YT.Player('iframe-wrap'+ sid, {
			height: '100%',
			width: '100%',
			videoId: youtube,
			rel : 0, //0으로 해놓아야 재생 후 관련 영상이 안뜸
			events: {
				'onReady': function(event) {
					event.target.playVideo();
					event.target.mute();
					event.target.setVolume(0);
				},
				'onStateChange': function(event) {
					if(event.data === 0) {
						event.target.playVideo();
					}
				}
			}
		})
	},

	CloseYoutube : function(){
		$("[data-selector=fixContainer]").remove();
	},

	Video : function(e) {
		var wrap = '';
		wrap += ' <div class="fix-video" data-selector="fixContainer">';
		wrap += ' 	<div class="m-main">';
		wrap += ' 		<div class="container" data-selector="referenceVideo"></div>';
		wrap += '		</div>';
		wrap += ' 	<a href="javascript:void(0)" class="close-video" data-action="closeVideo"><span class="a11y">영상 종료</span></a>';
		wrap += ' </div>';

		$("[data-selector=fixContainer]").remove();
		$("body").append(wrap);

		var seq = e.data("seq"),
			youtube = e.data("id"),
			container = "referenceVideo";

		Common.youtubePlay(container, seq, youtube);
	},

	Bind : function() {
		$('[data-button=hover]').unbind("mouseenter");
		$(document).on("mouseenter", "[data-button=hover]", function(e){
			var parentOffset = $(this).offset(),
				relX = e.pageX - parentOffset.left,
				relY = e.pageY - parentOffset.top;
			$(this).find('._hover').css({top:relY, left:relX})
		})
		.on('mouseout', "[data-button=hover]", function(e) {
			var parentOffset = $(this).offset(),
				relX = e.pageX - parentOffset.left,
				relY = e.pageY - parentOffset.top;
			$(this).find('._hover').css({top:relY, left:relX})
		});

		$('[data-action=youtube]').unbind("click");
		$(document).on("click", "[data-action=youtube]", function(){
			var sid = $(this).data("sid"),
				youtube = $(this).data("id");
			Common.youtubePlay(sid, youtube);
		});

		$(window).on("scroll",function(){
			var windowHeight = $(window).height();
			var scrollBtm = $(document).height();
			var secHeight = $('.f_area').height();

			if($(window).scrollTop() > windowHeight) {
				$('.scTop').slideDown(500);
			} else {
				$('.scTop').slideUp(500);
			}

			if($(window).scrollTop() + $(window).height() > $(document).height() - secHeight) {
				$('.scBottom').slideUp(500);
			} else {
				$('.scBottom').slideDown(500);
			}
		});

		$('[data-action=closeVideo]').unbind("click");
		$(document).on("click", "[data-action=closeVideo]", function(){
			Common.CloseYoutube();
		});

		$("[data-action=video]").unbind("click");
		$(document).on("click", "[data-action=video]", function(){
			Common.Video($(this));
		})
	},

	Init : function() {
		Common.Bind();
	}
};

var Motion = {
	Active : function(){
		var $top = $(".motion-line.top"),
			$btt = $(".motion-line.btt");

		if($top.index() > -1 && $btt.index() > -1) {
			var top = $top.offset().top,
				btt = $btt.offset().top;

			$.each($("._motionSec"), function(index, row){
				var rowTop = $(row).offset().top,
					rowHeight = $(row).outerHeight(),
					rowBtt = parseInt(rowTop) + parseInt(rowHeight);

				/*console.log(rowTop, rowBtt, "top : "+ top, "btt : "+ btt)
				console.log(top +" <= "+ rowTop +" && "+ btt +" >= "+ rowTop)*/

				if(!$(row).hasClass("_motionActive")) {
					if((top >= rowTop && top <= rowBtt) || (btt >= rowTop && btt <= rowBtt)) {
						$(row).addClass("_motionActive")
					}
				}
			})
		}
	},

	StickyFloat : function(){
		var $top = $("[data-sticky=floatBn][data-sid=top]"),
			$btt = $("[data-sticky=floatBn][data-sid=bottom]"),
			$floatBn = $("[data-selector=floatBn]");

		if($top.index() > -1) {
			var top = $top.offset().top,
				btt = $btt.offset().top,
				height = $("body").outerHeight(),
				width = $(window).outerWidth(),
				footHeight = $("#footer").outerHeight(),
				floatTop = $floatBn.offset().top,
				floatBtt = floatTop + $floatBn.outerHeight(),
				bttBase = height - footHeight;

			if(width > 768) {
				bttBase = bttBase - 50;
			} else {
				bttBase = bttBase;
			}

			if($("body").hasClass("_framePc")) {
				if(top > floatTop) {
					$floatBn.addClass("_sticky")
				}
				if(bttBase < floatBtt) {
					$floatBn.addClass("_stickyBtt")
				}

				if(btt < floatBtt) {
					if($floatBn.hasClass("_stickyBtt")) {
						$floatBn.addClass("_stickyReserve")
						$floatBn.removeClass("_stickyBtt")
					}
				}

				var kvBtt = $(".sec-kv").outerHeight() + 150;
				if($floatBn.hasClass("_sticky") && kvBtt > floatTop) {
					$floatBn.removeClass("_sticky")
					$floatBn.removeClass("_stickyReserve")
				}
			} else {

				/*if(bttBase < floatBtt) {
					$floatBn.addClass("_stickyBtt").css({"bottom" : footHeight})
				}
				if(height - footHeight > btt ) {
					$floatBn.removeClass("_stickyBtt").css({"bottom" : '0'})
				}*/
			}


			/*if($floatBn.hasClass("_sticky") && floatTop <= bttBase) {
				$floatBn.removeClass("_sticky")
			}

			if(floatBtt >= height) {
				$floatBn.addClass("_end")
			} else {
				$floatBn.removeClass("_end")
			}*/

		}
	},

	Bind : function(){
		$(window).scroll(function(){
			Motion.Active();
			Motion.StickyFloat();
		})
	},

	Init : function(){
		Motion.Bind();
		Motion.Active();
		Motion.StickyFloat();
	}
}

var GNB = {
	Reset : function(){
		ND.FN.noScroll('');
		$("#header").removeClass("_openMenu");
		$("#header").removeClass("_openAllMenu");
	},

	AllMenu : function(){
		if(!$("#header").hasClass("_openAllMenu")) {
			//ND.FN.noScroll('on');
			$("#header").addClass("_openAllMenu")
		} else {
			//ND.FN.noScroll('off');
			GNB.Reset();
		}
	},

	ScrollNav : function(){
		var $header = $("#header"),
			nowTop = $("#header").index() > -1 ? $("#header").offset().top : '';

		if(nowTop) {
			if(nowTop > 0) {
				if(!$header.hasClass("_move")) {
					$header.addClass("_move");
				}
			} else {
				$header.removeClass("_move");
			}
		}
	},

	NowPage: function(){
		var hash = location.hash.replace("#sec=", "");
		if(hash) {
			$("[data-click=scroll]").removeClass("_active");
			$("[data-click=scroll][data-sid="+ hash +"]").addClass("_active");
		}
		GNB.Scroll();
	},

	Sticky : function(){
		if($("#sticky-line").index() > -1) {
			var baseTop = $("#sticky-line").offset().top,
				stickyTop = 1;

			if (baseTop >= stickyTop) {
				$("#header, [data-action=moveTop]").addClass("_sticky");
			} else {
				$("#header, [data-action=moveTop]").removeClass("_sticky");
			}
		}
	},

	MoveScroll : function(e, sec){
		GNB.Reset();

		var arry = location.href.split("/"),
			depth = arry[arry.length - 1].split("?");

		if(depth[0] !== "reference") {
			if($("[data-selector=scrollDot]").index() > -1) {
				var sec = e ? e.attr("data-sid") : sec;
				if(sec) {
					//Nav.Reset();
					var headerHeight = $("#header").outerHeight(),
						offsetTop = sec === "top" ? 0 : parseInt($("[data-selector=scrollDot][data-sid="+ sec +"]").offset().top) + 1;

					$('html, body').animate({scrollTop: offsetTop}, 800);
				}
			}
		}
		else {
			location.href = "/#sec="+ e.attr("data-sid");
		}
	},

	ScrollSec : function(sec){
		var offsetTop = sec === "top" ? 0 : parseInt($("[data-selector=scrollDot][data-sid="+ sec +"]").offset().top) + 1;
		$('html, body').animate({scrollTop: offsetTop}, 800);
	},

	Scroll : function(){
		/* 현위치 hashchange */
		var $secTop = [],
			nowTop = $("#header").offset().top,
			winHeight = $(window).outerHeight(),
			wrapHeight = Math.floor($("#wrap").outerHeight());

		$("[data-selector=scrollDot]").each(function(i) {
			var data = {
				"top" : Math.floor($("[data-selector=scrollDot]").eq(i).offset().top),
				"hash" : $("[data-selector=scrollDot]").eq(i).attr("data-sid")
			}
			$secTop.push(data);
		})

		var nowHash = '',
			sid = '',
			length = $secTop.length - 1;

		if(length > 1) {
			$("body").removeClass("_sec-home _sec-about _sec-crew _sec-contact");

			var hash = '';
			if (nowTop + winHeight >= $secTop[length].top) {
				hash = "contact";
			} else {
				for (var i = 0, max = length; i < max; i += 1) {
					if (nowTop >= $secTop[i].top && nowTop < $secTop[(parseInt(i) + 1)].top) {
						hash = $secTop[i].hash;
					}
				}
			}
			nowHash = '#sec=' + hash;
			$("[data-click=scroll][data-sid="+ hash +"]").addClass("_active")
			if(location.hash !== nowHash) {
				location.href = nowHash;
			}
		}
	},

	HashChange : function(){
		setTimeout(function () {
			var hash = location.hash.replace("#sec=", "");
			$("[data-click=scroll]").removeClass("_active");
			$("[data-click=scroll][data-sid="+ hash +"]").addClass("_active");
		}, 60);
	},

	Bind : function(){
		window.addEventListener('hashchange', function(){
			GNB.NowPage();
		})

		$("[data-click=scroll]").unbind("click");
		$(document).on("click", "[data-click=scroll]", function(){
			GNB.MoveScroll($(this));
		})

		$("[data-action=moveTop]").unbind("click");
		$(document).on("click", "[data-action=moveTop]", function(){
			$('html, body').animate({scrollTop: 0}, 800);
		})

		$(window).scroll(function(){
			GNB.Sticky();
		})

		$(window).scrollStopped(function(ev){
			GNB.NowPage();
		});

		$("[data-action=allMenu]").unbind("click");
		$(document).on("click", "[data-action=allMenu]", function(){
			GNB.AllMenu();
		})
	},

	Init : function(){
		GNB.Bind();
		GNB.Sticky();
		GNB.NowPage();
		GNB.ScrollNav();
	}
}

var Reference = {
	GetDate : function(fromData, _callback) {
    $.ajax({
      type: 'POST',
      url: "/routes/api.php?v=20240123",
			dataType:"json",
			data:fromData,
			success: function(res) {
				if (typeof _callback === 'function') {
					if(res && res.result === 200) {
            var $data = res.datas;
            _callback.call(null, $data);
					}
				}
			}
		});
	},

	MoveUrl : function(e){
		var proj = e.data('seq'),
			url = "?"+ (__team ? "team="+ __team +"&" : "") +"proj="+ proj;
		location.href = url;
	},

	Detail : function(seq){
		var fromData = {
      seq : seq,
      mode : 'getDetail'
    };
		Reference.GetDate(fromData, function(res){
			var $data = res,
				team = $data.team;

      if(team === "design" || team === "btl") {
				var	html = '';
				html += '	<div class="detail-container" data-selector="detailContainer">';
				/*html += '		<section class="detail-sec sec-kv" style="background-image:url(' + $data.kv + ')">';
				html += '			<div class="m-main">';
				html += '				<header class="header-info" style="'+ ($data.kvColor ? 'color:'+ $data.kvColor : '') +'">';
				html += '					<p class="client">' + $data.client + '</p>';
				html += '					<h3 class="title tit s3">' + $data.title + ' ' + ($data.type ? '<br />' + $data.type : '') + '</h3>';
				html += '					<p class="date">' + $data.date + '</p>';
				html += '					<p class="keyword">' + $data.keyword + '</p>';
				html += '				</header>';
				html += '		</section>';*/
				$.each($data.section, function (index2, row2) {
          if (row2.overview) {
						html += '		<section class="detail-sec sec-overview" style="' + (row2.overviewBg ? 'background-color:' + row2.overviewBg : '') + '">';
						html += '			<div class="m-main">';
						html += '				<dl class="dl-flex">';
						html += '					<dt class="tit s4">OVERVIEW</dt>';
						html += '					<dd>' + row2.overview + '</dd>';
						html += '				</dl>';
						html += '			</div>';
						html += '		</section>';
					}
					html += '		<section class="detail-sec sec-' + (index2 === 0 ? 'kv' : index2) + '" style="' + (row2.bg_img ? 'background-image:url(' + row2.bg_img + ')' : '') + ' ' + (row2.bg_color ? 'background-color:' + row2.bg_color : '') + '">';
					html += '			<div class="m-main">';
					if (index2 === 0) {
						html += '				<header class="header-info" style="color:'+ ($data.subject_color ? $data.subject_color : '#fff') +'">';
						html += '					<p class="client">' + $data.client + '</p>';
						html += '					<h3 class="title tit s3">' + $data.subject + '</h3>';
						html += '					<p class="date">' + $data.year + '</p>';
						html += '					<p class="keyword">' + (team === "btl" ? $data.type : $data.etc3 ) + '</p>';
						html += '				</header>';
					}
					html += '				<figure class="figure-item">';
					html += '					<img src="' + row2.img + '" alt="" />';
					/*if (row3.caption) {
						html += '			<figcaption>' + row3.caption + '</figure>';
					}*/
					html += '				</figure>';
					html += '			</div>';
					html += '		</section>';
				})
				if($data.etc1) {
					html += '		<section class="detail-sec sec-footer" style="background-color:' + $data.etc2 + '">';
					html += '			<img src="' + $data.etc1 + '" alt="' + $data.client + '" />';
					html += '		</section>';
				}
				html += '		<a href="javascript:void(0)" class="btn-close" data-action="detailClose"><span class="a11y">닫기</span></a>';
				html += '	</div>';
			}

			if(team === "dev") {
				if($data.load) {
					var	html = '';
					html += '	<div class="detail-container type-dev img-box" data-selector="detailContainer" style="background-image:url(' + $data.kv + ')">';
					html += '		<section class="detail-sec">';
					html += '			<div class="m-main">';
					html += '				<header class="header-info">';
					html += '					<dl class="dl-item">';
					html += '						<dt>client</dt>';
					html += '						<dd>' + $data.client + '</dd>';
					html += '					</dl>';
					html += '					<dl class="dl-item">';
					html += '						<dt>wesite</dt>';
					html += '						<dd>' + $data.title + '</dd>';
					html += '					</dl>';
					html += '					<dl class="dl-item">';
					html += '						<dt>language</dt>';
					html += '						<dd>' + $data.keyword + '</dd>';
					html += '					</dl>';
					html += '					<dl class="dl-item">';
					html += '						<dt>feature</dt>';
					html += '						<dd>' + $data.type + '</dd>';
					html += '					</dl>';
					html += '				</header>';
					html += '				<div class="content-container" data-selector="load-container">';
					html += '					<div class="frame-wrap" data-action="zindex"><iframe src="' + $data.load + '"></iframe></div>';
					html += '					<div class="frame-wrap mobile _active" data-action="zindex"><iframe src="' + $data.load + '"></iframe></div>';
					html += '				</div>';
					html += '			</div>';
					html += '		</section>';
					html += '		<a href="javascript:void(0)" class="btn-close" data-action="detailClose"><span class="a11y">닫기</span></a>';
					html += '	</div>';
				} else {
					window.open($data.link, "_blank");
					return;
				}
			}

			if(team === "video") {
				return;
			}


			ND.FN.noScroll('on');
			$("[data-selector=detailContainer]").remove();
			$("body").append(html);
			setTimeout(function () {
				$("[data-selector=detailContainer]").addClass("_active");
			}, 50);
		})
	},

	Close : function(e){
		$("[data-selector=detailContainer]").removeClass("_active");
		setTimeout(function () {
			$("[data-selector=detailContainer]").remove();
			ND.FN.noScroll('off');
		}, 300);
		setTimeout(function () {
			var url = "/page/reference"+ (__team ? "?team="+ __team : "");
			location.href = url;
		}, 400);
	},

	Zindex : function(e){
		$("[data-action=zindex]").removeClass("_active")
		e.addClass("_active")
	},

	Bind : function(){
		$("[data-action=reference]").unbind("click");
		$(document).on("click", "[data-action=reference]", function(){
			Reference.MoveUrl($(this));
		})

		$("[data-action=detailClose]").unbind("click");
		$(document).on("click", "[data-action=detailClose]", function(){
			Reference.Close($(this));
		})

		$("[data-action=zindex]").unbind("mouseenter");
		$(document).on("mouseenter", "[data-action=zindex]", function(){
			Reference.Zindex($(this));
		})
	},

	Init : function(){
		Reference.Bind();
	}
}


