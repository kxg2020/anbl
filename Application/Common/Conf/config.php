<?php
return array(
    // 配置数据库连接
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'anbl',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  3306,        // 端口
    'DB_PREFIX'             =>  'an_',    // 数据库表前缀

    // 通常在实际项目中会选择使用URL重写模式
    'URL_MODEL' => 2,

    // 页面调试功能
    'SHOW_PAGE_TRACE' => true,

//    'SESSION_TYPE' => 'Db',
    'SESSION_AUTO_START'	=>  true,	// 是否自动开启Session
    'SESSION_TYPE'			=>  'Redis',	//session类型
    'SESSION_PERSISTENT'    =>  1,		//是否长连接(对于php来说0和1都一样)
    'SESSION_CACHE_TIME'	=>  1,		//连接超时时间(秒)
    'SESSION_EXPIRE'		=>  0,		//session有效期(单位:秒) 0表示永久缓存
    'SESSION_PREFIX'		=>  'sess_',		//session前缀
    'SESSION_REDIS_HOST'	=>  '127.0.0.1', //分布式Redis,默认第一个为主服务器
    'SESSION_REDIS_PORT'	=>  '6379',	       //端口,如果相同只填一个,用英文逗号分隔
    'SESSION_REDIS_AUTH'    =>  '',    //Redis auth认证(密钥中不能有逗号),如果相同只填一个,用英文逗号分隔

    'TMPL_PARSE_STRING' => [
        '__CSS__' =>  URL . '/Public/css',
        '__JS__' =>  URL . '/Public/js',
        '__IMG__' =>  URL . '/Public/images',
        '__ZTREE__' => URL . '/Public/ztree',
        '__PUBLIC__'=>URL.'/Public',
    ],

    'TOKEN_ON'      =>    false,  // 是否开启令牌验证 默认关闭
    'TOKEN_NAME'    =>    '__hash__',    //令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true

    'FILE_UPLOAD_TYPE'    =>    'Qiniu',
    'UPLOAD_TYPE_CONFIG'  =>    array(
        'secretKey'      => 'x5OoAluQ5x58FpzL3rONPH9rj1jnv0xe8HDwey0R', //七牛密码
        'accessKey'      => 'XQSWu87QQg5Poej0i1EKhFnh0ao5q47BfhLzxOIV', //七牛用户
        'domain'         => 'ocavymzvy.bkt.clouddn.com/', //域名
        'bucket'         => '0418', //空间名称
        'timeout'        => 300, //超时时间
    ),

    // 指定缓存的存储方式
    'DATA_CACHE_TYPE' =>  'Redis',
    // 指定Db缓存的表名字
//    'DATA_CACHE_TABLE' => 'shop_cache'
//    'MEMCACHE_HOST' => '127.0.0.1',
//    'MEMCACHE_PORT' => 11211,
//    'DATA_CACHE_TIMEOUT' => 0,
    'REDIS_HOST' => '127.0.0.1',
    'REDIS_PORT' => 6379,
);