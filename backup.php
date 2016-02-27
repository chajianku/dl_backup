<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
$today = date('Y-m-d');
$lastdo = option::get('dl_backup_lastdo');  
$d1=strtotime($today);
$d2=strtotime($lastdo);
$c=(int)round(($d1-$d2)/3600/24);
$day = (int)option::get('dl_backup_day');
$email = option::get('dl_backup_email');
if($c >= $day && !empty($day) && !empty($email)){
	global $m;
	$e = $m->query('SHOW TABLES');
	$dump  = '/*' . PHP_EOL;
	$dump .= 'Warning: Do not change the comments!!!'  . PHP_EOL . PHP_EOL;
	$dump .= 'Tieba-Cloud-Sign Database Backup' . PHP_EOL;
	$dump .= 'Tieba-Cloud-Sign Version : ' . SYSTEM_VER . PHP_EOL;
	$dump .= 'Tieba-Cloud-Sign Name : ' . SYSTEM_NAME . PHP_EOL;
	$dump .= 'MySQL Server Version : ' . $m->getMysqlVersion() . PHP_EOL;
	$dump .= 'Date: ' . date('Y-m-d H:i:s') . PHP_EOL;
	$dump .= '*/' . PHP_EOL . PHP_EOL;
	$dump .= '-------------- Start --------------' . PHP_EOL . PHP_EOL;
	$dump .= 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";' . PHP_EOL;
	$dump .= 'SET FOREIGN_KEY_CHECKS=0;' . PHP_EOL;
	$dump .= 'SET time_zone = "+8:00";' . PHP_EOL . PHP_EOL;
	while ($v = $m->fetch_array($e)) {
		$list  = $v;
		foreach ($list as $table) {
			$dump .= dataBak($table);
		}
	}
	$dump .= PHP_EOL . '-------------- End --------------';
	$title = SYSTEM_NAME . " " . date('Y-m-d') . " 数据库备份";
	$x = misc::mail($email,$title,"备份文件已附上，请查看附件",array('backup-'.date('Ymd').'.sql' => $dump));
	option::set('dl_backup_lastdo',date('Y-m-d'));
	if($x != true){
		option::set('dl_backup_log',date('Y-m-d H:i:s').'  数据库备份邮件发送失败！');
	} else {
		option::set('dl_backup_log',date('Y-m-d H:i:s').'  数据库备份邮件发送成功！');
	}	
} else {
    if ($c < $day && !empty($day) && !empty($email)) {
        option::set('dl_backup_log',date('Y-m-d H:i:s') . '  设置正确！上次备份日期：' . $lastdo);
    } else {
        option::set('dl_backup_log',date('Y-m-d H:i:s') . '  设置不正确，无法进行备份并且发送邮件！');
    }
}
