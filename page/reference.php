<?php
$http_host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$url = 'https://' . $http_host . $request_uri;
$__nowDate = date('Y-m-d');

include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/library.php";

$keword = isset($_REQUEST['keyword']) ? RemoveXSS($_REQUEST['keyword']) : '';
?>
<!doctype html>
<html lang="ko">
<head>
  <?php include_once $_SERVER["DOCUMENT_ROOT"]."/page/_inc/head.php"; ?>
</head>
<body>
<header id="header">
  <?php include_once $_SERVER["DOCUMENT_ROOT"]."/page/_inc/header.php"; ?>
</header>
<div id="wrap" class="page-reference page" style="background:none;">
  <div id="container" data-gsap="gsapContainer">
    <div class="bg-container main-bg b1" data-gsap="bg" data-eq="1" style="background-image: url(https://static.econtents.co.kr/_img/ct-planet/main_bg1.png)"></div>
    <div class="bg-container main-bg b2" data-gsap="bg" data-eq="2" style="background-image: url(https://static.econtents.co.kr/_img/ct-planet/main_bg2.png)"></div>

    <section class="sec sec1 _motionSec">
      <div class="m-main">
        <header class="article-header">
          <div class="dec-wrap">
            <h2 class="tit s3 _motion _motionToBottom">EXPERIENCE</h2>
          </div>
        </header>
        <div class="content-container">
          <form name="frm" method="post">
            <nav class="tag-nav" data-selector="tag">
              <label class="chk-label chk btn-label">
                <input type="radio" name="all" <?= (!$keword ? "checked=''" : '')?>/>
                <span class="btn"><span class="txt">All</span></span>
              </label>

              <label class="chk-label chk btn-label">
                <input type="radio" name="team" value="btl" <?= ($keword === "btl" ? "checked" : '')?> data-action="chk"/>
                <span class="btn"><span class="txt">Brand Design</span></span>
              </label>

              <label class="chk-label chk btn-label">
                <input type="radio" name="team" value="design" <?= ($keword === "design" ? "checked" : '')?> data-action="chk"/>
                <span class="btn"><span class="txt">Digital Design</span></span>
              </label>

              <label class="chk-label chk btn-label">
                <input type="radio" name="team" value="dev" <?= ($keword === "dev" ? "checked" : '')?> data-action="chk"/>
                <span class="btn"><span class="txt">Web site</span></span>
              </label>

              <label class="chk-label chk btn-label">
                <input type="radio" name="team" value="video" <?= ($keword === "video" ? "checked" : '')?> data-action="chk"/>
                <span class="btn"><span class="txt">Video</span></span>
              </label>

              <label class="chk-label chk btn-label" style="display:none;">
                <input type="radio" name="client" value="kt" data-action="chk"/>
                <span class="btn"><span class="txt">#kt</span></span>
              </label>

              <label class="chk-label chk btn-label" style="display:none;">
                <input type="radio" name="client" value="현대자동차" data-action="chk"/>
                <span class="btn"><span class="txt">#현대자동차</span></span>
              </label>

              <label class="chk-label chk btn-label" style="display:none;">
                <input type="radio" name="keyword" value="promotion" data-action="chk"/>
                <span class="btn"><span class="txt">#promotion</span></span>
              </label>
            </nav>
          </form>
          <div class="data-container" data-selector="appendList"></div>
        </div>
      </div>
    </section>
  </div>

  <progress max="100" value="0" class="ct-scroll" data-selector="scrollProgress"></progress>
</div>
<script src="//static.econtents.co.kr/_asset/_lib/masonry.pkgd.js"></script>
<script src="/_asset/_js/page.reference.js?v=20230824"></script>
</body>
</html>
