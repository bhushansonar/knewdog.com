#!/bin/bash
while true
do
 #/home/ramesh/backup.sh
 /usr/bin/php-cli /home/amuteyzj/public_html/projects/knewdog/index.php cron_email_issues process
 sleep 5
done