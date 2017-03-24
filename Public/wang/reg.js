(function(){
  //短信获取验证码
  $('#get').click(function(){
    $('#get').hide();
    $('#repeat_get').show();
    var time=60;
  var timer = setInterval(function(){
      time--;
      $('#get').hide();
      $('#repeat_get').show();
      $('#repeat_get').html(time+"秒后重新获取");

      if(time===0){
        $('#get').show();
        $('#repeat_get').hide();
        clearInterval(timer);
      }
    },1000);
  });
})();
