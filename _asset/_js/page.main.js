gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

/*
document.querySelectorAll("[data-click=scroll]").forEach((btn, index) => {
  btn.addEventListener("click", () => {
    console.log($(btn).data("sid"))
    gsap.to(window, {duration: 1, scrollTo:{y:"[data-selector=scrollDot][data-sid="+ $(btn).data("sid") +"]", offsetY:70}});
  });
});
*/

/*
let smoother = ScrollSmoother.create({
	wrapper: "#wrap",
	content: "#container",
	smooth: 1,
	normalizeScroll: true, // prevents address bar from showing/hiding on most devices, solves various other browser inconsistencies
	ignoreMobileResize: true, // skips ScrollTrigger.refresh() on mobile resizes from address bar showing/hiding
	effects: true,
	preventDefault: true
});
*/

/*let panels = gsap.utils.toArray("[data-gsap=panel]");
// we'll create a ScrollTrigger for each panel just to track when each panel's top hits the top of the viewport (we only need this for snapping)

panels.forEach((panel, i) => {
	ScrollTrigger.create({
		trigger: panel,
		start: () => panel.offsetHeight < window.innerHeight ? "top top" : "bottom bottom", // if it's shorter than the viewport, we prefer to pin it at the top
		pin: true,
		pinSpacing: false
	});
});*/

/*let getRatio = el => window.innerHeight / (window.innerHeight + el.offsetHeight);

gsap.utils.toArray("[data-gsap=panel]").forEach((section, i) => {
	section.bg = section.querySelector("[data-gsap=bg]");

	gsap.fromTo(section.bg, {
		backgroundPosition: () => i ? `50% ${-window.innerHeight * getRatio(section)}px` : "50% 0px"
	}, {
		backgroundPosition: () => `50% ${window.innerHeight * (1 - getRatio(section))}px`,
		ease: "none",
		scrollTrigger: {
			trigger: section,
			start: () => i ? "top bottom" : "top top",
			end: "bottom top",
			scrub: true,
			invalidateOnRefresh: true // to make it responsive
		}}
	});
});*/

gsap.to('[data-selector=scrollProgress]', {
	value: 100,
	ease: 'none',
	scrollTrigger: { scrub: 0.3 }
});

$(function(){
	Page.Init();
	$(window).on("load", function(){
		Common.youtubePlay('videoContainer', '0', "ZkG9krXJVhE");
	})
})

var Page = {
	RenderMap : function() {
		var geocoder = new kakao.maps.services.Geocoder();
		geocoder.addressSearch('서울시 강남구 봉은사로 63길 23 ', function(result, status) {
			nowLocation = {"lat" : result[0].x, "lon" : result[0].y}

			var mapContainer = document.getElementById('map'),
				mapOption = {
					center: new kakao.maps.LatLng(result[0].y, result[0].x),
					level: 4
				};

			var map = new kakao.maps.Map(mapContainer, mapOption);

			var imageSrc = 'https://ct-planet.co.kr/img/logo1_small.png', // 마커이미지의 주소입니다
				imageSize = new kakao.maps.Size(30, 30), // 마커이미지의 크기입니다
				imageOption = {offset: new kakao.maps.Point(27, 50)}; // 마커이미지의 옵션입니다. 마커의 좌표와 일치시킬 이미지 안에서의 좌표를 설정합니다.

			// 마커의 이미지정보를 가지고 있는 마커이미지를 생성합니다
			var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption),
				markerPosition = new kakao.maps.LatLng(result[0].y, result[0].x); // 마커가 표시될 위치입니다

			// 마커를 생성합니다
			var marker = new kakao.maps.Marker({
				position: markerPosition,
				/*image: markerImage // 마커이미지 설정*/
			});

			// 마커가 지도 위에 표시되도록 설정합니다
			marker.setMap(map);
		})
	},

	Request : function() {
		var $fm = $("[name=frm]");

		if(ND.Form.Validate($fm)){
			var ajaxUrl = '/api/api.request.php?mode=update',
				formData = $fm.serialize();

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajaxUrl,
				data: formData,
				success: function(res2) {
          if(res2.result === "duplicate") {
						alert("이미 문의가 완료되었습니다.");
						location.reload();
						return;
					}
					if(res2.result === "success") {
						alert("문의가 정상적으로 등록되었습니다.");
						location.reload();
						return;
					}
				}
			});
		}
	},

	Bind: function () {
		$("[data-action=inquiary]").unbind("click");
		$(document).on("click", "[data-action=inquiary]", function(){
			Page.Request();
		})

		$("[data-action=video]").unbind("click");
		$(document).on("click", "[data-action=video]", function(){
			Page.Video($(this));
		})

		$('[data-action=closeVideo]').unbind("click");
		$(document).on("click", "[data-action=closeVideo]", function(){
			Page.CloseYoutube();
		});
	},

	Init: function () {
		Page.Bind();
		Page.RenderMap();
	}
}