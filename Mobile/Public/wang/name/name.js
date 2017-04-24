$(function(){
    $('#tijiao').click(function(){
       realname = $('input[name = realname]').val();
        id_card = $('input[name = id_card]').val();
        if(realname == ''){
            layer.open({
                content: '真实姓名必填',
                style:'color:black'
                ,time: 2,
            });
            return false;
        }
        var reg_1 =   /^[\u4E00-\u9FA5]+$/;
        if(!reg_1.test(realname)){
            layer.open({
                content: '真实姓名必须为汉字',
                style:'color:black'
                ,time: 2,
            });
            return false;
        }
        if(!isNaN(realname)){
            layer.open({
                content: '真实姓名不能为数字',
                style:'color:black'
                ,time: 2,
            });
            return false;
        }

        if(id_card == ''){
            layer.open({
                content: '身份证号必填',
                style:'color:black'
                ,time: 2,
            });
            return false;
        }
        var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
        if(!reg.test(id_card)){
            layer.open({
                content: '身份证号格式不正确',
                style:'color:black'
                ,time: 2,
            });
            return false;
        }
        $.ajax({
            'type':'post',
            'dataType':'json',
            'url':location.protocol+'//'+window.location.host+'/Account/checkTrue',
            'data':{'realname':realname,'id_card':id_card},
            success:function(e){
                if(e.status == 1){
                    layer.open({
                        content: '保存成功',
                        style:'color:black'
                        ,btn: ['确定'],
                        yes:function(){
                            window.location.href = location.protocol+'//'+window.location.host+'/Account/index'
                        }
                    });
                }else{
                    layer.open({
                        content: '保存失败',
                        style:'color:black'
                        ,time: 2,
                    });
                    return false;
                }
            }
        });
    });
});