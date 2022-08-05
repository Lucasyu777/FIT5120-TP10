=== Database Access with Adminer ===
Contributors: lev0
Tags: database, sql, recovery, import
Requires at least: 5.3
Tested up to: 6.0
Stable tag: 1.0.0
Requires PHP: 5.6.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Provides a secure interface to your WordPress database using Adminer, the popular database administration tool.

== Description ==

[adminer]: https://www.adminer.org/

[*Adminer*][adminer] is a database administration tool that allows viewing and editing of databases tables, routines, triggers, etc. It also allows running SQL statements to import data, make bulk changes, or perform other complex operations. It is similar in function to *phpMyAdmin*.

It is intended for use by developers and those who have had experience with databases. The connection is limited to the one saved in your WordPress configuration, and access is granted only to logged-in accounts that possess the `edit_plugins` capability (normally admins). This ensures it can only used by those who already have enough privilege to pose a risk to the installation. Each and every request to Adminer will first be authenticated using your WordPress session. Some security plugins impose extra restrictions on admin sessions, so this plugin may not work if you have one installed.

Note that there is no way to limit access to a single database (i.e. your WordPress install's) if you have other databases on the same host protected by the same credentials.

== Installation ==

After installing the plugin, go to *Settings > Adminer* to configure the plugin and confirm the warning about the risk to your data. Go to *Tools > Adminer* to use it.

== Screenshots ==

1. The settings screen
2. Link to adminer
3. The Adminer interface, in the `pepa-linha-dark` theme.
