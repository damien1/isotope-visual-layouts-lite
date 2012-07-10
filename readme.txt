=== Plugin Name ===
Contributors: damiensaunders
Donate link: 
Tags: Database, Cron, Backup, Schedule, Logs, SQL
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: 2.0

DBC Backup 2 is a simple way to schedule daily database backups using the wp-cron system.

== Description ==

DBC Backup 2 is a simple way to schedule daily database backups using the wp cron system. 

I've used this plugin for several years and was disappointed that the author Chris T aka Tefra no longer maintained it so I have forked it. I tried to contact the author but without any luck.

You can select when and where your backup will be generated. If your server has support you can select between three different compression formats: none, Gzip and Bzip2. The plugin will try to auto create the export directory, the .htaccess and an empty index.html file to protect your backups.

The backup file is also protected by a small hash key which make it impossible for someone to guess the backup name and download it.

During generation, a log will be generated which includes, the generation date, file, filesize, status amd the duration of the generation.

Except the cron backup, you have also the ability to take backups immediately. The backups are identical of what phpmyadmin produces because DBC Backup is using the key procedures of phpmyadmin.

DBC Backup was built to be fast, flexible and as simple as possible.

= What's New =
Version 2.0
-----------
- submitted as 'fork' of the existing plugin
- tested and confirmed working on WordPress 3.4.1

Version 1.1
-----------
- Added option to specify the interval between crons. e.g 1 hour, 2 days, 3 weeks, 4 months etc etc
- Added option to remove older than x days backups after a new backup generation

Version 1.0
-----------
- First Initial Release

== Installation ==

1. Upload folder dbcbackup to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You can enter the admin page from the link 'DB Cron Backup' on the top menu.
4. Configure the plugin settings and you are ready. You'll need to know your server path to a folder you want the backup saved.

* If the plugin can't create the export directory you will have to do it manually and don't forget to chmod 777 it.
* If you are upgrading, deactivate the plugin first and remove all old files, before starting.

== Frequently Asked Questions ==

= Why create a server based back-up =
It makes sense to me to keep the SQL database backup where you will most likely need it if something goes wrong. Many web hosts provide a large amount of free space for you to store files. So rather than having to pay someone else for storing your database backup you can use the free space you already have. 

= Aren't server based back-ups insecure? =
Not really, server based back-ups are only unsafe if your server is prone to fail or poorly protected from hacking.

= I want to make my backup more secure =
That's easy, the plugin creates a .htaccess file in the backup folder. You can open this file and add to this code. The backup folder is protected against browsing or direct file access. 

= The plugin takes a backup whenever I setup a specific cron job =
If the time of the cron is before the current time the wp cron system is adding the cron job to run at the next page view, despite how long ago it is set. 

= Why don't any compression formats appear? =
Because Gzip and Bzip2 are not installed on your server.

= Does this work for multisite? =
Yes if you are site admin then each site can run its own version of the plugin and backups of the SQL database can be created.



== Screenshots ==

