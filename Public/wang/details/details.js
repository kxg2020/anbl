$(function(){
  $('#title_img').on('mousemove',function(){
    var x=getMousePosition().x;
    var y=getMousePosition().y;
    $('#title').show().css({
      left:x,
      top:y
    });

  }).on('mouseleave',function(){
     $('#title').hide();
  });
  function getMousePosition(e){
    var a=e||window.event;
    var x=a.pageX||(a.clientX+(document.documentElement.scrollLeft||document.body.scrollLeft));
    var y=a.pageY||(a.clientY+(document.documentElement.scrollTop||document.body.scrollTop));
    return{
    'x':x,
    'y':y
    }
  }


       var backflag=true;
      var frameworkflag=false;
      var analyseflag=true;
      var commentflag=true;
  $('.movie_introduce>p').click(function(){

      var text=$(this)[0].innerText.slice(1);
      
      if(text=='预期回报'){
        $('.back').fadeToggle('slow')
        if(backflag){
          $('#back>span').text('-');
          backflag=false;
        }else{
          $('#back>span').text('+');
          backflag=true;
        }
      }
      if(text=='故事结构'){
        $('.framework').fadeToggle('slow')
        if(frameworkflag){
          $('#framework>span').text('-');
          frameworkflag=false;
        }else{
          $('#framework>span').text('+');
          frameworkflag=true;
        }
      }
      if(text=='故事分析'){
        $('.analyse').fadeToggle('slow')
        if(analyseflag){
          $('#analyse>span').text('-');
          analyseflag=false;        
        }else{
          $('#analyse>span').text('+');
          analyseflag=true;
        }
      }
      if(text=='专业影评'){
        $('.comment_film').fadeToggle('slow')
        if(commentflag){
          $('#comment_film>span').text('-');
          commentflag=false;
        }else{
          $('#comment_film>span').text('+');
          commentflag=true;
        }
      }
  });

$('#anbl_argement').click(function(){
  $('.argement').fadeIn('slow');
})
$('.close_btn').click(function(){
  $('.argement').fadeOut('slow');
})

 $('#cancel').click(function(){
  $('.suport_bg').fadeOut('slow');
 })

$('.argement').click(function(){
  return false;
})

});
