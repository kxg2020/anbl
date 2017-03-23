<?php
return array(
    // 配置数据库连接
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '192.168.16.72', // 服务器地址
    'DB_NAME'               =>  'an_db',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  3306,        // 端口
    'DB_PREFIX'             =>  'an_',    // 数据库表前缀

    // 通常在实际项目中会选择使用URL重写模式
    'URL_MODEL' => 2,

    // 页面调试功能
    'SHOW_PAGE_TRACE' => true,

    'TMPL_PARSE_STRING' => [
        '__CSS__' =>  '/Public/css',
        '__JS__' =>  '/Public/js',
        '__IMG__' => '/Public/images',
        '__ZTREE__' => '/Public/ztree',
        '__PUBLIC__'=>'/Public',
    ],

    'TOKEN_ON'      =>    false,  // 是否开启令牌验证 默认关闭
    'TOKEN_NAME'    =>    '__hash__',    //令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true

    // 指定缓存的存储方式
    'DATA_CACHE_TYPE' =>  'Redis',

    // 发送短信配置
    'PHONE_API_APP_KEY'=>'d86223080830f5cd6e98b08893d73658',
    'VERIFY_CODE_TPL'=>'xxxx',

    // 绑定上传方式
    'FILE_UPLOAD_TYPE'    =>    'Qiniu',
    'UPLOAD_TYPE_CONFIG'  =>    array(
        'secretKey'      => '-ozcCzNuPfZQePdMUtEHzp6gfuQQfS-GR4IOmxen', //七牛密码
        'accessKey'      => 'Oxorx2oRMYXe8bZCRvuoNpyOexkJAgKPgs14Gv4O', //七牛用户
        'domain'         => 'on58ea572.bkt.clouddn.com', //域名
        'bucket'         => 'macarin', //空间名称
        'timeout'        => 300, //超时时间
    ),
);