Desktop Notification
====================
Notifies when new notification or message is arrived on Facebook and marks the notification as read.

Also notifies when new mail is arrived on gmail.

Requirements
------------
1] Any Linux distribution (with preferably cinnamon shell as cinnamon preserves notifications sent by `notify-send`)

2] `notify-send` utility

	$apt-get install notify-osd
3] `php5-cli` with IMAP extension

	$apt-get install php5-cli
	$apt-get install php5-imap
Usage
-----
1] Clone the project using git.

	$cd /var/www
	$git clone https://github.com/kishorm23/desktop-notification.git
2] [Create new app on Facebook](https://developers.facebook.com/apps) with integration type `Website with Facebook Login`.

3] Configure `config.php` with proper App-ID and App secret obtained from step 2.

4] Obtain access token by authenticating on `http://localhost/auth.php`.

5] Modify `notify.php` with proper access token obtained from step 4.

6] Modify `notify.php` with gmail username and password.

7] Run `notify.php` from terminal.

	$php [path_to_script]/notify.php

8] Automate the task on every startup with `crontab`.

	$crontab -e
	@reboot php [path_to_script]/notify.php > /dev/null

Screenshot
----------
![Screenshot](https://raw.github.com/kishorm23/desktop-notification/master/scr/screenshot.png "screenshot")
