$(function(){
	$('.bg>p').click(function () {
			var id=$(this)[0].id;
			$('.bg>p').removeClass('p_choice');
			$('.content_right>div').hide();
			if(id=='title1'){
				$('.bg>p').eq(0).addClass('p_choice');
			    $('.content_right>div').eq(0).show();
			}
			if(id=='title2'){
				$('.bg>p').eq(1).addClass('p_choice');
			    $('.content_right>div').eq(1).show();
			}
			if(id=='title3'){
				$('.bg>p').eq(2).addClass('p_choice');
			    $('.content_right>div').eq(2).show();
			}
			if(id=='title4'){
				$('.bg>p').eq(3).addClass('p_choice');
			    $('.content_right>div').eq(3).show();
			}
		})

	var divflag=true;
	var div2flag=true;
	$('#div1').click(function(){
		if(divflag){
			divflag=false;
			$('.div1').fadeIn('slow');
			$('#div1>span').html('-');
		}else{
			divflag=true;
			$('.div1').fadeOut('slow');
			$('#div1>span').html('+');
		}
	})
	$('#div2').click(function(){
		if(div2flag){
			div2flag=false;
			$('.div2').fadeIn('slow');
			$('#div2>span').html('-');
		}else{
			div2flag=true;
			$('.div2').fadeOut('slow');
			$('#div2>span').html('+');
		}
	})
	
})