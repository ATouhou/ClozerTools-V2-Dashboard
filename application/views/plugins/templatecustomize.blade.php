  <style type="text/css">
     .template-customize {
          position: fixed;
          bottom: 0;
          right: 35px;
          background: #000;
          background: rgba(0,0,0,0.9);
          width: 154px;
          z-index: 10000;
          border: 2px solid #B6B6B6;
          border-bottom: 0;
          border-radius: 1px;
          box-shadow: 0 0 10px #000;
          height: 0;


     }
     
     .template-customize i {
          font-size: 30px;
          position: absolute;
          color: #000;
          top: -46px;
          left: 49px;
          padding: 10px 10px 4px 10px;
          border-radius: 100% 100% 0 0;
          background: #fff;
          background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0, #FFFFFF),color-stop(1, #B6B6B6));
          background-image: -o-linear-gradient(bottom, #FFFFFF 0%, #B6B6B6 100%);
          background-image: -moz-linear-gradient(bottom, #FFFFFF 0%, #B6B6B6 100%);
          background-image: -webkit-linear-gradient(bottom, #FFFFFF 0%, #B6B6B6 100%);
          background-image: -ms-linear-gradient(bottom, #FFFFFF 0%, #B6B6B6 100%);
          background-image: linear-gradient(to bottom, #FFFFFF 0%, #B6B6B6 100%);
     }
     
     .template-customize i:hover {
          cursor: pointer;
          color: #3748d4;

     }
     
     .template-customize ul {
          list-style: none;
          float: left;
          margin: 10px 0 10px 20px;
          padding: 0;
     }
     
     .template-customize ul li {
          width: 45px;
           border:1px solid #000;
          height: 30px;
          overflow: hidden;
          margin-bottom: 2px;
     }
     
     .template-customize ul li:hover {
          cursor: pointer;
           border:1px solid #fff;
          opacity: 0.8;
     }
</style>
        <!-- Template skin customize(you can remove this anytime) -->
          <div class="template-customize hidden-xs" >
               <i class="icon-cogs" id="tc-toggle"></i>
               <ul data-elem=".deskBack">
                    <li class="header">Body</li>
                    <li><img src="{{URL::to_asset('images/')}}wood_grey.png" alt=""></li>
                    <li><img src="{{URL::to_asset('images/')}}wood_dark.png" alt=""></li>
                    <li><img src="{{URL::to_asset('images/')}}escheresque_ste-light.png" alt=""></li>
                    <li><img src="{{URL::to_asset('images/')}}wood_dark.png" alt=""></li>
                    <li><img src="{{URL::to_asset('img/')}}body-bg/bluetec.png" alt=""></li>
                    <li><img src="{{URL::to_asset('img/')}}body-bg/cement.png" alt=""></li>
                    <li><img src="{{URL::to_asset('img/')}}body-bg/leather.png" alt=""></li>

               </ul>
               <ul data-elem="#page-content">
                    <li class="header">Content</li>
                    <li><img src="{{URL::to_asset('img/')}}content-bg/content-bg.jpg" alt=""></li>
                    <li><img src="{{URL::to_asset('img/')}}content-bg/lines.png" alt=""></li>
                    <li><img src="{{URL::to_asset('images/')}}swirl_pattern.png" alt=""></li>
                    <li><img src="{{URL::to_asset('images/')}}fresh_snow.png" alt=""></li>
                    <li><img src="{{URL::to_asset('images/')}}diagonal_waves.png" alt=""></li>
                    <li><img src="{{URL::to_asset('img/')}}content-bg/cloth.png" alt=""></li>
                    <li><img src="{{URL::to_asset('img/')}}content-bg/grid.png" alt=""></li>
                    <li><img src="{{URL::to_asset('img/')}}content-bg/gray-leather.png" alt=""></li>
                    <li><img src="{{URL::to_asset('img/')}}content-bg/jean.png" alt=""></li>
                    <li><img src="{{URL::to_asset('img/')}}content-bg/light.png" alt=""></li>
                    <li><img src="{{URL::to_asset('img/')}}content-bg/subtle.png" alt=""></li>
                    <li><img src="{{URL::to_asset('images/')}}retina_wood.png" alt=""></li>
               </ul>
          </div>
          <script>

               $(document).ready(function(){
                     if(localStorage){
                      if(localStorage.getItem("themeBack")){
                        var e = localStorage.getItem("themeBack");
                        var f = localStorage.getItem("themeBody");
                        applyBackground($('.deskBack'),e);
                        applyBackground($('#page-content, .lightPaperBack'),f);
                      	} 
                     }
                  function applyBackground(target, src){
                    var bg = 'url('+src+')';
                    $(target).css('background', bg);
                  }
                    $('.template-customize ul li').click(function(){
                         var getElem = $(this).closest('ul').attr('data-elem');
                         var src = $(this).find('img').attr('src');
                         if(getElem==".deskBack"){
                          localStorage.setItem("themeBack",src);
                         } else {
                          localStorage.setItem("themeBody",src);
                          getElem = getElem+", .lightPaperBack, .profilePage";
                         }
                         applyBackground(getElem, src);
                    });
                    var tempToggle=0;
                    $('#tc-toggle').click(function(){
                        if(tempToggle==0){
                          tempToggle=1;
                           $('.template-customize').css('height','auto');
                        } else {
                           $('.template-customize').css('height','0');
                           tempToggle=0;
                        }
                    });
                  });
          </script>