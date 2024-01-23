gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

gsap.to('[data-selector=scrollProgress]', {
  value: 100,
  ease: 'none',
  scrollTrigger: { scrub: 0.3 }
});

$(function(){
  Page.Init();
})

var Page = {
  GetReference : function(formData, _callback) {
    formData = $.extend({
      mode : "",
      team: "",
      seq: "",
      keyword: "",
      client : ""
    }, formData || {});

    $.ajax({
      type: 'POST',
      url: "/routes/api.php?v=20240123",
      dataType:"json",
      data : formData,
      success: function(res) {
        console.log(formData, res)
        if (typeof _callback === 'function') {
          if(res && res.result === 200) {
            var $data = res.datas;
            /*if( !formData.seq && !formData.team && !formData.keyword && !formData.client) {
              var $data = res.data;
            } else {
              var $data = [];
              $.each(res.data, function (index, row) {
                if( (formData.seq && formData.seq == row.seq) || (formData.team && formData.team == row.team) || (formData.keyword && formData.keyword == row.keyword) || (formData.client && formData.client == row.client) ) {
                  $data.push(row);
                }
              })
            }*/
            _callback.call(null, $data);
          }
        }
      }
    });
  },

  Shuffle(data) {
    if(data) {
      var j, x, i;
      for (i = data.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = data[i];
        data[i] = data[j];
        data[j] = x;
      }
    }
    return data;
  },

  LoadPage : function(){
    var team = ND.RETURN.param("team"),
      proj = ND.RETURN.param("proj") ? ND.RETURN.param("proj") : '';

    $("[name=all]").prop("checked", false);
    if(!team) {
      $("[name=all]").prop("checked", true);
    } else {
      $("[name=team][value="+ team +"]").prop("checked", true);
    }

    Page.Search();

    if(proj) {
      Reference.Detail(proj)
    }
  },

  RenderReference : function(formData) {
    Page.GetReference(formData, function(res){
      var $data = Page.Shuffle(res),
        html = '';

      //html += '	<div class="grid-sizer"></div>';
      $.each($data, function(index, row){
        html += '	<div class="data-item type-'+ row.team +'" data-selector="dataItem">';
        html += '		<a href="javascript:void(0)" class="link-item" data-action="'+ (row.team === "video" ? "video" : "reference") +'" data-seq="'+ row.seq +'" data-team="'+ row.team +'" data-id="'+ (row.youtube ? row.youtube : '') +'">';
        html += '			<div class="img-wrap">';
        //html += '				<div class="img-box" style="background-image:url('+ row.thumb +');"></div>';
        html += '				<img src="'+ row.thumb_img +'" class="thumb" alt="" />';
        html += '			</div>';
        html += '			<div class="ft-wrap">';
        html += '				<div class="dec-top">';
        html += '					<p class="client">'+ (row.client ? row.client : '') +'</p>';
        html += '					<strong class="title tit s4">'+ row.subject +'</strong>';
        html += '				</div>';
        html += '				<small class="keyword">'+ (row.team == "btl" ? row.etc4 : row.etc3) +'</small>';
        html += '			</div>';
        html += '		</a>';
        html += '	</div>';
      })

      $("[data-selector=appendList]").html("");
      $("[data-selector=appendList]").append(html);
      var $grid = $("[data-selector=appendList]").masonry({
        itemSelector: '[data-selector=dataItem]',
        percentPosition: true,
        columnWidth: '.grid-sizer'
      });

      $grid.masonry('destroy');
      $grid.imagesLoaded().progress( function() {
        $grid.masonry();
      });
    })
  },

  ChangeChk : function(){
    var team = $("[name=team]:checked").val(),
      url = "?team="+ team;
    location.href = url;
  },

  Search : function() {
    //console.log($("[name=kind]:checked").length);

    var formData = {
      mode : 'getList',
      team : $("[name=team]:checked").val() ? $("[name=team]:checked").val() : '',
      client : $("[name=client]:checked").val() ? $("[name=client]:checked").val() : '',
      keyword : $("[name=keyword]:checked").val() ? $("[name=keyword]:checked").val() : ''
    }
    Page.RenderReference(formData);
    $("[name=all]").prop("checked", false);
  },

  AllChk : function() {
    if($("[name=all]").prop("checked")) {
      $("[data-action=chk]").prop("checked", false);
      Page.RenderReference();
    }
  },

  Bind: function () {
    $("[data-action=chk]").unbind("change");
    $(document).on("change", "[data-action=chk]", function(){
      Page.ChangeChk()
    });

    $("[name=all]").unbind("change");
    $(document).on("change", "[name=all]", function(){
      Page.AllChk()
    });
  },

  Init: function () {
    Page.LoadPage();
    Page.Bind();

    /*var keyword = ND.RETURN.param("keyword") ? ND.RETURN.param("keyword") : '',
      formData = keyword ? {team : keyword} : '';
    Page.RenderReference(formData);*/

    $("[data-depth=references]").addClass("_active")
    $("[data-selector=tag]").addClass("_active")
  }
}