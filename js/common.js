$(window).on('load',function() {
    /* WEBフォント読み込み対策
    window.WebFontConfig = {
        google: { families: ['Noto+Sans+JP', 'Roboto:wght@700', 'Noto+Serif+JP', 'Noto+Sans+JP:wght@900', 'Crimson+Text'] },
        active: function() {
          sessionStorage.fonts = true;
        }
      };
    (function() {
        var wf = document.createElement('script');
        wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();*/
    // リンク先が画像の場合 zoomクラスを追加
    $('a[href$=".jpg"], a[href$=".jpeg"], a[href$=".gif"], a[href$=".png"]').each(function(i){
        $(this).addClass("zoom");
    });
    parallax();
    $(window).scroll(function (){
        parallax();
    });
    function parallax(){
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        var header_chk = $("#main").height() ? $("#main").height() - 80 :  windowHeight * 0.8;
        var base_top = 0;
        var before_top = 0;
        var cnt = 0;
        scroll >  windowHeight * 0.5 ? $('.pageTop').addClass("active") : $('.pageTop').removeClass("active");
        scroll >  header_chk ? $('header').addClass("active") : $('header').removeClass("active");
        $('.parallax:not(.active)').each(function(i){
            var this_top = $(this).offset().top;
            cnt = before_top == this_top || this_top - base_top < windowHeight ? cnt+1 : 0;
            if( ( scroll == 0 && 0 > ( this_top - windowHeight - 100 ) ) || ( scroll > ( this_top - windowHeight + 20 ) ) ) {
                $(this).delay(300 * cnt).queue(function(){$(this).addClass("active")});
                before_top = this_top;
                base_top = this_top - base_top >= windowHeight ? this_top : base_top;
            } else {
                //$(this).removeClass("active");
            }
        });
    }
    //URLにアンカーでの移動先が書かれている場合
    (function(a){
        var urlHash = location.hash;
        if(urlHash) {
            $('body,html').stop().scrollTop(0);
            $('body,html').delay(1000).queue(function() {
                var headerHeight = $('header') ? $('header').height() : 0;
                var speed = 400;
                var position = $(urlHash).offset().top - 10 - headerHeight; // 移動先を数値で取得
                $(this).animate({ scrollTop: position }, speed, 'swing').dequeue();
            });
        }
    }());
    $('a[href^="#"]').click(function(event) {
        var headerHeight = $('header') ? $('header').height() : 0;
        var speed = 400; // スクロールの速度 ミリ秒
        var href= $(this).attr("href");
        var target = $(href == "#" || href == "" ? 'html' : href);// 移動先を取得
        var position = target.offset().top - 10 - headerHeight; // 移動先を数値で取得
        $('body,html').animate({scrollTop:position}, speed, 'swing');
        event.preventDefault();
     });
    // リンク先が画像の場合 モーダルで表示
    $('a[href$=".jpg"], a[href$=".jpeg"], a[href$=".gif"], a[href$=".png"]').click(function(event) {
        var href= $(this).attr("href");
        var title= $(this).attr("title") ? $(this).attr("title") : "";
        var width= $(this).attr("width") ? $(this).attr("width") : "auto";
        $("#modal-window .modal-content").html('<img src="'+href+'" width="'+width+'" alt="'+title+'">').css('width', width);
        $('input#modal-show').prop('checked', true);
        event.preventDefault();
    });
    // リンク先が動画の場合 モーダルで表示
    $('a[href$=".mp4"]').click(function(event) {
        var href= $(this).attr("href");
        $('#modal-window .modal-content').html('<video src="'+href+'" autoplay controls preload="auto" controlsList="nodownload" oncontextmenu="return false;"></video>');
        $('#modal-show').prop('checked', true);
        event.preventDefault();
    });
    //モーダルを閉じた時内容を空に
    $('label[for="modal-show"]').click(function() {
        $('#modal-window .modal-content').html('');
    });
    /* 会員機能を利用する場合
    $('label[for=login]').on('click', function() {
        if( ! $('#login').prop('checked') ){
            $('#nav-input').prop('checked', false);
            $('#header_tel').prop('checked', false);
        }
    });
    $('label[for=nav-input]').on('click', function() {
        if( ! $('#nav-input').prop('checked') ){
            $('#login').prop('checked', false);
            $('#header_tel').prop('checked', false);
        }
    });*/
});

//QueryStrings取得
/*var getQueryStrings = function(){
    var result = [], hash; 
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&'); 
    for(var i = 0; i < hashes.length; i++) { 
        hash = hashes[i].split('='); 
        result.push(hash[0]); 
        if( hash[1] ){
            var text = hash[1].split('#')
            result[hash[0]] = text[0];   
        }
    }
    return result;
}*/
