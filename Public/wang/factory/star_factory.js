$(function(){
	var div=$('#star_content>div').eq(0);
	$('.sb-container>div').click(function(){
		var id=$(this)[0].id;

        if(id!==div.attr('class')&&$(this).attr('class')!='last_title'&&$(this).attr('class')!='last_title ff-active'){
      var newdiv;
      for(var i=0;i<=$('.star_content>div').length;i++){
        if(id==$('.star_content>div').eq(i).attr('class')){
          newdiv=$('.star_content>div').eq(i);
          break;
        }
      }
			newdiv.show();
			div.hide();
			div=newdiv;
		}	
	});


	$('.classify p').click(function(){
    var txt=$(this)[0].innerHTML;
        $('.sb-container>div').removeClass("ff-active");
        $('.star_content>div').hide();
    $('.classify p').removeClass('choice');
    if(txt==='优秀演员'){
      $('.classify p').eq(0).addClass('choice');
      $('.nice_actor').show();
      $('.nice_director').hide();
      $('.nice_work').hide();
        $('#sb-container>div').eq(0).addClass('ff-active')
        $('#star_content>div').eq(0).show();
        div=$('#star_content>div').eq(0);
        $( '#sb-container' ).swatchbook( {
            openAt : 0
        } );
    }
    if(txt==='优秀导演'){
      $('.classify p').eq(1).addClass('choice');
      $('.nice_actor').hide();
      $('.nice_director').show();
      $('.nice_work').hide();
        $('#sb-container1>div').eq(0).addClass('ff-active')
        $('#star_content1>div').eq(0).show();
        div=$('#star_content1>div').eq(0);
      $( '#sb-container1' ).swatchbook( {
          openAt : 0
        } );
    }
    if(txt==='优秀作品'){
      $('.classify p').eq(2).addClass('choice');
      $('.nice_actor').hide();
      $('.nice_director').hide();
      $('.nice_work').show();
        $('#sb-container2>div').eq(0).addClass('ff-active')
        $('#star_content2>div').eq(0).show();
        div=$('#star_content2>div').eq(0);
      $( '#sb-container2' ).swatchbook( {
          openAt : 0
        } );
    }
  });

});