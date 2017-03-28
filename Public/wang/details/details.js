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

  /**
   * 评论
   */
  $('body').on('click','.reply',function(){
    var _html = '<div class="replyContent"><textarea  name="content" rows="2" cols="80" placeholder="回复" autofocus></textarea><input type="submit" value="回复" style="cursor: pointer"></div>';
    var dom = $(this).next('.replyContent');
    if(dom.length > 0){
      $(this).nextAll('.replyContent').remove();
    }else{
      $('.replyContent').remove();
      $(this).after(_html);
    }
  });


});
