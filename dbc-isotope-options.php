<?php
// Damien's Admin Panel v2

// with many thanks https://github.com/bueltge/WordPress-Admin-Style

/**
 * You shouldn't be here.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2>Isotope Visual Layouts Lite</h2>
	<?php settings_errors();?>
	<div class="metabox-holder has-right-sidebar">
		
<div class="inner-sidebar">

			<div class="postbox">
				<h3><span>Thanks from Damien</span></h3>
				<div class="inside">
		<p>Thanks for installing this. 
		<br /><a target="_blank" href="http://damien.co/?utm_source=WordPress&utm_medium=dbc-isotope-lite-installed&utm_campaign=Isotope-Layouts">Damien</a></p> 
		<p>Please add yourself to <a target="_blank" href="http://wordpress.damien.co/wordpress-mailing-list/?utm_source=WordPress&utm_medium=dbc-isotope-lite-installed&utm_campaign=Isotope-Layouts">my mailing list</a> to be the first to hear about updates for this plugin.</p>
		<p>Let me and your friends know you installed this:</p>
	<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://wordpress.damien.co/isotope" data-counturl="http://wordpress.damien.co/isotope" data-count="horizontal" data-via="damiensaunders">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>	

				</div>
			</div>

			<div class="postbox">
				<h3><span>Help & Support</span></h3>
				<div class="inside">
					<?php echo 'Thank you for using version ' . ISOTOPE_LITE_VERSION; ?>
					<ul>
					<li><a target="_blank" href="http://wordpress.damien.co/isotope/?utm_source=WordPress&utm_medium=dbc-isotope-lite-installed&utm_campaign=Isotope-Layouts">Help & FAQ's</a></li>
					<li><a target="_blank" href="http://wordpress.damien.co/?utm_source=WordPress&utm_medium=dbc-isotope-lite-installed&utm_campaign=Isotope-Layouts">More WordPress Tips & Ideas</a></li>
					</ul>
				</div>
			</div>
			<div class="postbox">
				<h3><span>Plugin Suggestions</span></h3>
				<div class="inside">
				<p>Here's another plugin of mine that I think you'll need.</p>
				<ul>
					<li><a target="_blank" href="http://wordpress.damien.co/dbc-backup-2/?utm_source=WordPress&utm_medium=dbc-isotope--lite-installed&utm_campaign=Isotope-Layouts">DBC Backup 2</a> - secure and easy backup for your WordPress SQL database. Automated schedule and delete older backups</li>
				</ul>
				</div>
			</div>			
			
			<!-- ... more boxes ... -->

		</div> <!-- .inner-sidebar -->

		<div id="post-body">
			<div id="post-body-content">

				<div class="postbox">
					<h3><span>Get Started with Isotope Visual Layouts</span></h3>
					<div class="inside">
						<p>I've made this free plugin as easy to use as possible. There is no code to change or files to move. So please enjoy.</p>
						<ol>
						<li>Add a <a target="_blank" href="post-new.php?post_type=page">new Page</a></li>
						<li>Add the shortcode [dbc_isotope]</li>
						<li>Remember to give your page a name</li>
						<li>Publish the page</li>
						<li>View your page with Isotope</li>
						</ol>
					</div> <!-- .inside -->
				</div>
				<div class="postbox">

		
		<?php isotope_vpl_plugin_options_page(); ?>
		
		<ul>
		<li> Want to <a target="_blank" href="http://whitetshirtdigital.com/shop/isotope-for-wordpress-plugin-pro-licence/?utm_source=WordPress&utm_medium=dbc-isotope-lite-installed&utm_campaign=Isotope-Layouts">change my CSS or HTML then please help by buying a licence from me</a></li>
		</ul>
		</div> <!-- .inside -->
		</div>



				<div class="postbox">
					<h3><span>Shortcode Options</span></h3>
					<div class="inside">
						<p>You can configure the number of posts to show. Here are a couple of examples</p>
						<ul>
						<li> [dbc_isotope posts=5] will show 5 posts</li>
						<li> [dbc_isotope posts=-1] will show all posts</li>
						<li> [dbc_isotope posts=-1 post_type=feedback] will show all posts from custom post type feedback</li>
						<li> [dbc_isotope cats=5] will show 10 posts from category 5</li> 
						<li> [dbc_isotope order=DESC] defaults to most recent posts first but you can change this to ASC to go with oldest.

						</ul>
					</div> <!-- .inside -->
				</div>
			</div> <!-- #post-body-content -->
		</div> <!-- #post-body -->

	</div> <!-- .metabox-holder -->
	
</div> <!-- .wrap -->