<?php
$http_host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$url = 'https://' . $http_host . $request_uri;
$__nowDate = date('Y-m-d');

include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/library.php";
?>
<!doctype html>
<html lang="ko">
<head>
  <?php include_once $_SERVER["DOCUMENT_ROOT"]."/page/_inc/head.php"; ?>
</head>
<body class="web-02">
<header id="header">
  <?php include_once $_SERVER["DOCUMENT_ROOT"]."/page/_inc/header.php"; ?>
</header>
<div id="wrap" class="page-main page" style="background:none;">
  <div id="container" data-gsap="gsapContainer">
    <div class="bg-container main-bg b1" data-gsap="bg" data-eq="1" style="background-image: url(https://static.econtents.co.kr/_img/ct-planet/main_bg1.png)"></div>
    <div class="bg-container main-bg b2" data-gsap="bg" data-eq="2" style="background-image: url(https://static.econtents.co.kr/_img/ct-planet/main_bg2.png)"></div>

    <section class="sec sec1 _motionSec" data-selector="scrollDot" data-sid="home">
      <div class="m-main">
        <div class="dec-wrap" aria-hidden="true" data-selector="heading">
          <div class="col col1">
            <span class="txt _motion _motionToBottom _delay1">W</span>
            <span class="txt _motion _motionToBottom _delay1-5">e</span>
            <span class="txt _motion _motionToBottom _delay2">'</span>
            <span class="txt _motion _motionToBottom _delay2-5">r</span>
            <span class="txt _motion _motionToBottom _delay3">e</span>
          </div>
          <div class="col col1">
            <span class="txt _motion _motionToBottom _delay3-5">u</span>
            <span class="txt _motion _motionToBottom _delay4">n</span>
            <span class="txt _motion _motionToBottom _delay4-5">i</span>
            <span class="txt _motion _delay15 _hyphen"></span>
            <span class="txt _motion _motionToBottom _delay5-5">v</span>
            <span class="txt _motion _motionToBottom _delay6">e</span>
            <span class="txt _motion _motionToBottom _delay6-5">r</span>
            <span class="txt _motion _motionToBottom _delay7">s</span>
            <span class="txt _motion _motionToBottom _delay7-5">e</span>
          </div>
          <dl class="col-dl" data-speed="1">
            <dt>
              <strong class="tit _motion _motionToLeft _delay8">wereverse ː</strong>
            </dt>
            <dd>
              <p class="dec _motion _motionToLeft _delay9">하나(uni) 하나가  모여 무한한 상상력의 verse</p>
            </dd>
          </dl>
          <p class="dec d1 _motion _motionToLeft _delay10">
            <span class="bg" style="white-space: nowrap"><span class="txt c-mint">Contents</span>&nbsp;<span class="txt c-purple">Planet</span></span> 에서 모든 경험을 디자인 합니다..
          </p>
        </div>
      </div>
    </section>

    <section class="sec sec2" data-selector="scrollDot" data-sid="about">
      <div class="m-main">
        <div class="dec-flex">
          <dl class="col-left" data-speed="0.8">
            <dt data-speed="1">
              <h3 class="tit s3 ico i1">About</h3>
            </dt>
            <dd data-speed="1">
              <p class="dec">
                콘텐츠플래닛은 전문성, 크리에이티브를 갖춘 멀티 콘텐츠 크루입니다. <br />
                다양한 콘텐츠를 개발, 연구하고 있으며, 콘텐츠플래닛만의 방법을 통해 <br class="tablet-hide"/>
                영향력 있는 결과를 도출할 수 있도록 끊임없이 노력합니다.
              </p>
            </dd>
          </dl>

          <dl class="col-right" data-speed="1">
            <dt data-speed="1">
              <h3 class="tit s3 ico i2">Mission</h3>
            </dt>
            <dd data-speed="1">
              <p class="dec">
                브랜드의 니즈를 반영한 수준 높은 솔루션 제공을 약속합니다. <br />
                풍부한 경험과 크리에이티브한 아이디어를 통해 우리의 전략을 현실화합니다.
              </p>
            </dd>
          </dl>
        </div>
      </div>
    </section>

    <section id="sec3" class="sec sec3_1" data-selector="scrollDot" data-sid="crew" >
      <div class="scroll_wrap">
        <article class="article a0" data-stellar-background-ratio="0.5" data-gsap="panel">
          <div class="m-main">
            <header class="crew-header article-header">
              <div class="dec-wrap">
                <h2 class="tit s2" data-speed="1">Creative crew</h2>
                <div class="dec" data-speed="1">
                  차별화된 브랜드 이미지를 구축을 위해 Interative한 영상및 Creative한 디자인을 결합하여 <br class="small-hide" />
                  모든 사용자의 편의성에 기반한 UX/UI를 기획 하고 이모든 경험을 웹화면으로 서비스를 제공하기위하여 <br class="small-hide" />
                  콘텐츠 플래닛의 크루들이 모였습니다.
                </div>
              </div>
            </header>
          </div>
        </article>

        <article class="article a1 c-black parallax cover-background" data-stellar-background-ratio="0.5" data-gsap="panel" style="background-image:url(https://static.econtents.co.kr/_img/ct-planet/bg_crew1.jpg)">
          <!--<div class="img-box" style="background-image:url(https://static.econtents.co.kr/_img/ct-planet/bg_crew1.jpg)" data-gsap="bg"></div>-->
          <div class="m-main">
            <header class="article-header">
              <div class="dec-wrap">
                <h2 class="tit s2" data-speed="1">Brand Design</h2>
                <div class="dec tit t4" data-speed="1">
                  <strong>Brand Exprience Design</strong><br />
                  브랜드의 정체성을 디자인하고 정체성을 만들기위해  <br class="m-hide" />
                  시각뿐만 아닌 공감적인 경험을 디자인 함으로 브랜드를 만났을떄 <br class="m-hide" />
                  가치와 의미를 고객에게 긍정적인 이미지를 형성, 경험을통해 가치를 높일수있습니다.
                </div>
              </div>

              <a href="/page/reference?keyword=btl" class="btn" data-speed="1">References</a>
            </header>
          </div>
        </article>

        <article class="article a2 parallax cover-background" data-stellar-background-ratio="0.5" data-gsap="panel" style="background-image:url(https://static.econtents.co.kr/_img/ct-planet/bg_crew2.jpg)">
          <!--<div class="img-box" style="background-image:url(https://static.econtents.co.kr/_img/ct-planet/bg_crew2.jpg)" data-gsap="bg"></div>-->
          <div class="m-main">
            <header class="article-header">
              <div class="dec-wrap">
                <h2 class="tit s2" data-speed="1">Digital Design</h2>
                <div class="dec tit t4" data-speed="1">
                  <strong>User Exprience Design</strong><br />
                  화면과 사람으로 접하는 면을 좀더 쉽게 경함할수있는 디자인하여 <br class="m-hide" />
                  경험을 통해 사용자로 하여금 깊은 공감을 이끌어낼수있습니다.
                </div>
              </div>

              <a href="/page/reference?keyword=design" class="btn" data-speed="1">References</a>
            </header>
          </div>
        </article>

        <article class="article a2 c-black parallax cover-background" data-stellar-background-ratio="0.5" data-gsap="panel" style="background-image:url(https://static.econtents.co.kr/_img/ct-planet/bg_crew3.jpg)">
          <!--<div class="img-box" style="background-image:url(https://static.econtents.co.kr/_img/ct-planet/bg_crew3.jpg)" data-gsap="bg"></div>-->
          <div class="m-main">
            <header class="article-header">
              <div class="dec-wrap">
                <h2 class="tit s2" data-speed="1">Development</h2>
                <div class="dec tit t4" data-speed="1">
                  <strong>Web / Apps</strong><br />
                  브랜드가 가장 돋보이는 경험을 더많은 소비자와 소통을 할수있도록 <br class="m-hide" />
                  다양한 프로젝트의 경험을 바탕으로 web 화면에 담을수있게 도와드립니다. <br class="m-hide" />
                  웹사이트 구축으로 끝이아닌 유지보수를 통해 <br class="m-hide" />
                  문제를 찾고 트렌드에 맞는 가치있는 경험을 제공합니다.
                </div>
              </div>

              <a href="/page/reference?keyword=dev" class="btn" data-speed="1">References</a>
            </header>
          </div>
        </article>

        <article class="article a3 parallax cover-background" data-stellar-background-ratio="0.5" data-gsap="panel" style="background-color:#000">
          <div class="img-box video-container" style="background-color:#000" data-gsap="bg" data-selector="videoContainer"></div>
          <div class="m-main">
            <header class="article-header">
              <div class="dec-wrap">
                <h2 class="tit s2" data-speed="1">Video Product</h2>
                <div class="dec tit t4" data-speed="1">
                  <strong>New Media</strong><br />
                  급변하는 트랜드로 색다른 시각과 접근방식의 디지털 마케팅 전략이 요구되고있습니다. <br />
                  소비자의 니즈에 맞는 차별화되고 최적화된 콘텐츠를 제작하여드립니다.
                </div>
              </div>

              <a href="/page/reference?keyword=video" class="btn" data-speed="1">References</a>
            </header>
          </div>
        </article>
      </div>
    </section>

    <section class="sec sec4" data-gsap="panel" data-selector="scrollDot" data-sid="contact">
      <div class="m-main">
        <div class="col-flex flex">
          <div class="col-left">
            <div class="col">
              <header class="article-header">
                <h2 class="tit s3">Contact</h2>
              </header>
              <div class="map-container">
                <div class="map-wrap" id="map"></div>
              </div>
              <div class="dec-wrap">
                <p class="map_txt">서울특별시 강남구 봉은사로 63길 23(삼성동)</p>
                <a href="tel:025466202" class="link-item">02.546.6202</a>
              </div>
            </div>
          </div>

          <div class="col-right">
            <div class="col">
              <header class="article-header">
                <h2 class="tit s3">Request</h2>
              </header>
              <form method="post" name="frm">
                <label class="label">
                  <input type="text" placeholder="성명을 입력하세요. *" name="appl_name" data-validate="req"/>
                </label>
                <label class="label">
                  <input type="text" placeholder="이메일을 입력하세요. *" name="appl_email" data-validate="req"/>
                </label>
                <label class="label">
                  <textarea placeholder="문의내용을 읿력하세요. *" name="inquiary" data-validate="req"></textarea>
                </label>
                <input type="hidden" name="seq_code" value="<?=makeSeqCode()?>"/>
              </form>
              <a href="javascript:void(0)" class="btn c-white" data-action="inquiary">Submit</a>
            </div>
          </div>
        </div>
      </div>
      <footer id="footer">
        <?php include_once $_SERVER["DOCUMENT_ROOT"]."/page/_inc/footer.php"; ?>
      </footer>
    </section>
  </div>

  <progress max="100" value="0" class="ct-scroll" data-selector="scrollProgress"></progress>
</div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=b4e9412ebb754b56a116352a0e58765b&libraries=services,clusterer,drawing"></script>
<link rel="stylesheet" href="//static.econtents.co.kr/_asset/_lib/WOW-master/css/libs/animate.css" type="text/css" />
<script src="//static.econtents.co.kr/_asset/_lib/WOW-master/dist/wow.min.js"></script>
<script src="//static.econtents.co.kr/_asset/_lib/skrollr-master/dist/skrollr.min.js"></script>
<script src="/_asset/_js/page.main.js?v=20220701"></script>
<script type="text/javascript">
  $(function(){
    skrollr.init({
      smoothScrolling: false,
      mobileCheck: function(){
        if((/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera)){
          // mobile device
        }
      }
    });
  })
</script>
</body>
</html>
