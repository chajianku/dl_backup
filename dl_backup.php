<?php 
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

$day = option::get('dl_backup_day');
if(empty($day)){option::set('dl_backup_day',1);}

function dl_backup_navi() {
	echo '<li ';
	if(isset($_GET['plug']) && $_GET['plug'] == 'dl_backup') { echo 'class="active"'; }
	echo '><a href="index.php?mod=admin:setplug&plug=dl_backup"><span class="glyphicon glyphicon-cloud-upload"></span> 自动备份数据库</a></li>';
}

addAction('navi_2','dl_backup_navi');
addAction('navi_3','dl_backup_navi');
