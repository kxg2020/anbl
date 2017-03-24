$(function(){
	//搜索框的长度切换
	$('#search_cont').on('mouseenter',function(){
		$('#search_cont').animate({
			width:'120px'
		},'slow');
	}).on('mouseleave',function(){
			$('#search_cont').animate({
			width:'40px'
		},'slow');
	});
	for(var i=0;i<$('.complate_point').length;i++){
		var number=$('.complate_point').eq(i).text();
		var height=1-toPoint(number);
		$(".top").eq(i).animate({
		height:toPercent(height)
	},'slow');
	}

//百分数转小数
function toPoint(percent){
    var str=percent.replace("%","");
    str= str/100;
    return str;
}
//小数转百分数
function toPercent(point){
    var str=Number(point*100).toFixed(1);
    str+="%";
    return str;
}

//转换影院
$('.move_list p').click(function(){
	var cont=$(this)[0].innerHTML;
	$('.move_list p').removeClass('choice');
	if(cont==='星级'){
		$('.move_list p').eq(0).addClass('choice');
	}
	if(cont==='院线'){
		$('.move_list p').eq(1).addClass('choice');
	}
	if(cont==='网路IP'){
		$('.move_list p').eq(2).addClass('choice');
	}
});



window.onscroll = function(){
 var t = document.documentElement.scrollTop || document.body.scrollTop;
 //console.log(t)
 if( t >= 1000 ) {
  $('.move_list').css({
  	top:t-600
  });
 } else {
   $('.move_list').css({
  	top:200
  });
 }

 };

 window.onresize=function(){
 	screen_auto();
 }


 //不同屏幕的适配
 function screen_auto (){
 	var bodyWidth=$('body').width();
	if(bodyWidth>=1200&&bodyWidth<=1400){
		$('header').height(600);
		$('#center').height(600);
		$('#slider .slide').height(600).width(860);
	}else if (bodyWidth>1400&&bodyWidth<=1600) {
		$('header').height(700);
		$('#center').height(700);
		$('#slider .slide').height(700).width(980);
	}else if (bodyWidth>1600&&bodyWidth<=1800) {
		$('header').height(800);
		$('#center').height(800);
		$('#slider .slide').height(800).width(1100);
	}else {
		$('header').height(900);
		$('#center').height(900);
		$('#slider .slide').height(900).width(1200);
	}
 }
	screen_auto();	


});
