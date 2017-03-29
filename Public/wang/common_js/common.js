$(function(){
  $(".burger2").click(function(){
      $(".burger2").toggleClass("open");
      $('.menu_content').fadeToggle('slow');
    });

    $('#search_cont').on('mouseenter',function(){
  		$('#search_cont').animate({
  			width:'120px'
  		},'slow');
  	})
    $('body').click(function(){
      $('#search_cont').animate({
        width:'40px'
      },'slow');
    });
    $('#search_cont').click(function(){
      return false;
    })


    function navMarginauto(){
      $('.nav>div').css({
        width:$('.logo').width()+$('.top_nav').width()+$('.login_reg').width()+150
      })
    }
    navMarginauto();
});
