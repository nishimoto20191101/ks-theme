var sliderCss = document.createElement('link');
sliderCss.rel = 'stylesheet';
sliderCss.href = "/_cms/wp-content/themes/ks/css/slick.min.css"; 
document.head.appendChild(sliderCss);
$(window).on('load',function() { // フォーム完了画面
var sliderScript = document.createElement('script'); 
sliderScript.src = "/_cms/wp-content/themes/ks/js/slick.min.js"; 
document.head.appendChild(sliderScript);
sliderScript.addEventListener('load', function(){
 $('#voice .slider').slick({
   autoplay:true,
   infinite:true,
   slidesToShow:3,
   slidesToScroll:1,
   prevArrow:'',
   nextArrow:'',
   dots:false,
   centerMode:false,
   centerPadding:'2rem',
   autoplaySpeed:4000,
   responsive:[{
       breakpoint:599,//モニターの横幅が599px以下
       settings:{
         slidesToShow:1
       }
    }]
 });
});
 document.addEventListener( 'wpcf7mailsent', function( event ){
   location = './thanks/';
  });
});