<?php
/**
 *
 *
 *
 **/

if(!defined('WP_ADMIN') OR !current_user_can('manage_options')) wp_die(__('You do not have sufficient permissions to access this page.'));

dbcbackup_locale();
$cfg = get_option('dbcbackup_options'); 
if($_POST['quickdo'] == 'dbc_logerase')
{
	check_admin_referer('dbc_quickdo');
	$cfg['logs'] = array();
	update_option('dbcbackup_options', $cfg);
}
elseif($_POST['quickdo'] == 'dbc_backupnow')
{
	check_admin_referer('dbc_quickdo');
	$cfg['logs'] = dbcbackup_run('backupnow');
}
elseif($_POST['do'] == 'dbc_setup')
{
	check_admin_referer('dbc_options');
	$temp['export_dir']		=	rtrim(stripslashes_deep(trim($_POST['export_dir'])), '/');
	$temp['compression']	=	stripslashes_deep(trim($_POST['compression']));
	$temp['gzip_lvl']		=	intval($_POST['gzip_lvl']);
	$temp['period']			=	intval($_POST['severy']) * intval($_POST['speriod']);
	$temp['active']			=	(bool)$_POST['active'];
	$temp['rotate']			=	intval($_POST['rotate']);
	$temp['logs']			=	$cfg['logs'];
	
	$timenow 				= 	time();
	$year 					= 	date('Y', $timenow);
	$month  				= 	date('n', $timenow);
	$day   					= 	date('j', $timenow);
	$hours   				= 	intval($_POST['hours']);
	$minutes 				= 	intval($_POST['minutes']);
	$seconds 				= 	intval($_POST['seconds']);
	$temp['schedule'] 		= 	mktime($hours, $minutes, $seconds, $month, $day, $year);
	update_option('dbcbackup_options', $temp);

	if($cfg['active'] AND !$temp['active']) $clear = true;
	if(!$cfg['active'] AND $temp['active']) $schedule = true;
	if($cfg['active'] AND $temp['active'] AND (array($hours, $minutes, $seconds) != explode('-', date('G-i-s', $cfg['schedule'])) OR $temp['period'] != $cfg['period']) )
	{
		$clear = true;
		$schedule = true;
	}
	if($clear) 		wp_clear_scheduled_hook('dbc_backup');
	if($schedule) 	wp_schedule_event($temp['schedule'], 'dbc_backup', 'dbc_backup');
	$cfg = $temp;
	?><div id="message" class="updated fade"><p><?php _e('Options saved.') ?></p></div><?php
}

$is_safe_mode = ini_get('safe_mode') == '1' ? 1 : 0;
if(!empty($cfg['export_dir']))
{
	if(!is_dir($cfg['export_dir']) AND !$is_safe_mode)
	{
		@mkdir($cfg['export_dir'], 0777, true);
		@chmod($cfg['export_dir'], 0777);

		if(is_dir($cfg['export_dir']))
		{
			$dbc_msg[] = sprintf(__("Folder <strong>%s</strong> was created.", 'dbcbackup'), $cfg['export_dir']);
		}
		else
		{
			$dbc_msg[] = $is_safe_mode ? __('PHP Safe Mode Is On', 'dbcbackup') : sprintf(__("Folder <strong>%s</strong> wasn't created, check permissions.", 'dbcbackup'), $cfg['export_dir']);								
		}
	}
	else
	{
		$dbc_msg[] = sprintf(__("Folder <strong>%s</strong> exists.", 'dbcbackup'), $cfg['export_dir']);
	}
	
	if(is_dir($cfg['export_dir']))
	{
		$condoms = array('.htaccess', 'index.html');	
		foreach($condoms as $condom)
		{
			if(!file_exists($cfg['export_dir'].'/'.$condom))
			{
				if($file = @fopen($cfg['export_dir'].'/'.$condom, 'w')) 
				{	
					$cofipr =  ($condom == 'index.html')? '' : "Order allow,deny\ndeny from all";
					fwrite($file, $cofipr);
					fclose($file);
					$dbc_msg[] =  sprintf(__("File <strong>%s</strong> was created.", 'dbcbackup'), $condom);
				}	
				else
				{
					$dbc_msg[] = sprintf(__("File <strong>%s</strong> wasn't created, check permissions.", 'dbcbackup'), $condom);			
				}
			}
			else
			{
				$dbc_msg[] = sprintf(__("File <strong>%s</strong> exists.", 'dbcbackup'), $condom);
			}
		} 
	}
}
else
{
	$dbc_msg[] = __('Specify the folder where the backups will be stored', 'dbcbackup');
}

/**
 *
 * DBC Backup
 * Options Panel
 **/
 ?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"></div>
			<h2><?php _e('DBC Backup Options', 'dbcbackup'); ?></h2>
			<div class="metabox-holder has-right-sidebar">
					
			<div class="inner-sidebar">
			
						<div class="postbox">
							<h3><span>Thanks from Damien</span></h3>
							<div class="inside">
					<p>Thanks for installing this. 
					<br /><a target="_blank" href="http://damien.co/?utm_source=WordPress&utm_medium=dbc-sitewide-installed&utm_campaign=WordPress-Plugin">Damien</a></p> 
					<p>Please add yourself to <a target="_blank" href="http://wordpress.damien.co/wordpress-mailing-list/?utm_source=WordPress&utm_medium=dbc-sitewide-installed&utm_campaign=WordPress-Plugin">my mailing list</a> to be the first to hear about updates for this plugin.</p>
					<p>Let me and your friends know you installed this:</p>
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://wordpress.damien.co/plugins" data-counturl="http://wordpress.damien.co/plugins" data-count="horizontal" data-via="damiensaunders">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>	
			
							</div>
						</div>
			
						<div class="postbox">
							<h3><span>Help & Support</span></h3>
							<div class="inside">
								<p>Hi, I'm metabox 2!</p>
								<ul>
								<li><a href="http://wordpress.damien.co/isotope/">Help & FAQ's</a></li>
								<li><a href="http://wordpress.damien.co/">More WordPress Tips & Ideas</a></li>
								</ul>
							</div>
						</div>
						<div class="postbox">
							<h3><span>Plugin Suggestions</span></h3>
							<div class="inside">
							<p>Here's another plugin of mine that I think you'll need.</p>
							<ul>
								<li><a href="http://wordpress.damien.co/dbc-backup/">DBC Backup 2</a> - safe and easy backup for your WordPress database.</li>
							</ul>
							</div>
						</div>			
						<div class="postbox">
							<h3><span>Latest from Damien</span></h3>
							<div class="inside">
								<?php dbc_isotope_rss_display() ?>
							</div>
						</div>		
						<!-- ... more boxes ... -->
			
					</div> <!-- .inner-sidebar -->
			
					<div id="post-body">
						<div id="post-body-content">
			
							<div class="postbox">
								<h3><span>Metabox 3</span></h3>
								<div class="inside">
									<p>Hi, I'm metabox 3!</p>
								</div> <!-- .inside -->
							</div>
			
							<div class="postbox">
								<h3><span>Metabox 4</span></h3>
								<div class="inside">
									<p>Hi, I'm metabox 4!</p>
								</div> <!-- .inside -->
							</div>
			
						</div> <!-- #post-body-content -->
					</div> <!-- #post-body -->
			
				</div> <!-- .metabox-holder -->
				
			</div> <!-- .wrap -->
