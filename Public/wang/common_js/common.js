$(function(){
  $(".burger2").click(function(){
      $(".burger2").toggleClass("open");
      $('.menu_content').fadeToggle('slow');
    });

    $('#search_cont').on('mouseenter',function(){
  		$('#search_cont').animate({
  			width:'120px'
  		},'slow');
  	}).on('mouseleave',function(){
  			$('#search_cont').animate({
  			width:'40px'
  		},'slow');
  	});
});
