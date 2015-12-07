<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
function callback_init() {
	$day = option::get('dl_backup_day');
	$email = option::get('dl_backup_email');
	if(empty($email)){option::set('dl_backup_email',EMAIL);}
	if(empty($day)){option::set('dl_backup_day',1);}
	cron::set('dl_backup','plugins/dl_backup/backup.php',0,0,0);
}

function callback_inactive() {
	cron::del('dl_backup');
}
?>
