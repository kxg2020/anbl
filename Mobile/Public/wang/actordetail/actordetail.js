$(function(){
    $('select[name = role]').change(function(){
        //>> 获取当前所选角色的id
        roleId = $(this).val();
        //>> 获取当前电影的id
        movieId = $('input[name = movieId]').val();

        $('input[name = roleId]').val(roleId);
        //>> 请求角色详情
        $.ajax({
            'type':'post',
            'dataType':'json',
            'url':location.protocol+'//'+window.location.host+'/Star/roleChange',
            'data':{
                'roleId':roleId,
                'movieId':movieId
            },
            success:function(e){
                $('.intro').text(e.data.intro);
                $('.feature').text(e.data.feature);
                $('.figure').text(e.data.figure);
            }
        });
    });
});