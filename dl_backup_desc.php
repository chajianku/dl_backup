<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
return array(
	'plugin' => array(
		'name'        => '数据库自动备份',
		'version'     => '1.2',
		'description' => '自动备份数据库发送到邮箱',
		'onsale'      =>  false,
		'url'         => 'http://www.tbsign.cn',
		'for'         => '3.8+',
        'forphp'      => '5.3'
	),
	'author' => array(
		'author'      => 'D丶L',
		'email'       => 'admin@tbsign.cn',
		'url'         => 'http://tbsign.cn'
	),
	'view'   => array(
		'setting'     => true,
		'show'        => false,
		'vip'         => false,
		'private'     => false,
		'public'      => false,
		'update'      => false,
	),
	'page'   => array()
);
