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
});
