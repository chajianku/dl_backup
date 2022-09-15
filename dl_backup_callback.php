<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
function callback_init() {
	option::set('dl_backup_day',1);
	option::set('dl_backup_email',EMAIL);
	option::set('dl_backup_hour',10);
	cron::set('dl_backup','plugins/dl_backup/backup.php',0,0,0);
}

function callback_inactive() {
	cron::del('dl_backup');
}

function callback_remove() {
	global $m;
	option::del('dl_backup_day');
	option::del('dl_backup_email');
	option::del('dl_backup_hour');
	$m->query("DELETE FROM `".DB_NAME."`.`".DB_PREFIX."options` WHERE `name` LIKE '%dl_backup_%'");
}
