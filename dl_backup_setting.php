<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
if (isset($_GET['ok'])) {
	echo '<div class="alert alert-success">设置已成功保存！</div>';
}
$email = option::get('dl_backup_email');
if (empty($email)) {
	echo '<div class="alert alert-info">请设置您的接收数据库备份的邮箱，否则无法正常使用此插件！</div>';
}
if (isset($_GET['wrong'])) {
	echo '<div class="alert alert-wrong">同步失败，邮件发送失败，请检查邮件相关设置！</div>';
}
if (isset($_GET['success'])) {
	echo '<div class="alert alert-success">同步成功，请在您填写的邮箱中查看备份数据库信息！</div>';
}
if(isset($_GET['set'])){
	global $m;
	option::set('dl_backup_email' , $_POST['email']);
	option::set('dl_backup_day' , $_POST['day']);
	option::set('dl_backup_cxbf' , $_POST['cxbf']);
	ReDirect(SYSTEM_URL.'index.php?mod=admin:setplug&plug=dl_backup&ok');
	}
if(isset($_GET['update'])){
	global $m;
	if(!empty($email)){
		$e = $m->query('SHOW TABLES');
		$aaa = 'Tables_in_'.DB_NAME;
		$dump  = '<pre>#Warning: Do not change the comments!!!'  . "\n";
		$dump .= '#Tieba-Cloud-Sign Database Backup' . "\n";
		$dump .= '#Version:' . SYSTEM_VER . "\n";
		$dump .= '#Date:' . date('Y-m-d H:m:s') . "\n";
		$dump .= '############## Start ##############' . "\n";
		while ($v = $m->fetch_array($e)) {
			$list  = $v;
			foreach ($list as $table) {
				$dump .= dataBak($table);
			}
		}
		$dump .= "\n" . '############## End ##############</pre>';
		$title = SYSTEM_NAME . " " . date('Y-m-d') . " 数据库备份";
		$x = misc::mail($email,$title,$dump);
		if($x != true){
			option::set('dl_backup_log',date('Y-m-d H:m:s').'  数据库备份邮件发送失败！');
		    ReDirect(SYSTEM_URL.'index.php?mod=admin:setplug&plug=dl_backup&wrong');}
			else {
			option::set('dl_backup_log',date('Y-m-d H:m:s').'  数据库备份邮件发送成功！');
			ReDirect(SYSTEM_URL.'index.php?mod=admin:setplug&plug=dl_backup&success');
			}
		}
	}

?>
<h3>自动数据库备份设置</h3>
</br>
<form action="index.php?mod=admin:setplug&plug=dl_backup&set" method="post">
<div class="input-group">
  <span class="input-group-addon">接收备份邮箱</span>
  <input type="email" name="email" class="form-control" value="<?php echo option::get('dl_backup_email') ?>">
</div><br>
<div class="input-group">
  <span class="input-group-addon">备份间隔（天）</span>
  <input type="number" name="day" class="form-control" value="<?php echo option::get('dl_backup_day') ?>">
</div></br>
<div class="input-group">
</div></br></br>
<p><b>最新日志：<?php echo option::get('dl_backup_log'); ?></b></p></br>
<p>注：请将计划任务顺序设置为0，以防止计划任务卡住导致没有备份！使用立即备份功能请确保已经设置了接收邮箱并保存！</p></br>
  <button type="submit" class="btn btn-success">保存设置</button>&nbsp;<button type="button" onclick="window.location = 'index.php?mod=admin:setplug&plug=dl_backup&update';" class="btn btn-danger">立即备份</button>
</form>