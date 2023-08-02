#!/bin/bash

servers[0]="srv1.local"
servers[1]="srv2.local"
servers[2]="srv3.local"

size=${#servers[@]}
index=$(($RANDOM % $size))

SERVER=${servers[$index]}

FILE_TO_SYNCHRONIZE_LOCAL="/path/to/backend/rules.ini"
FILE_TO_SYNCHRONIZE_REMOTE="/path/to/frontend/rules.ini"
EMAIL_RECIPIENT="synchronization-notifications@example.com"
SED_TEMPFILE="/path/to/backend/_synchronize/sed/file.tmp"
SYNCHRONIZE_CONTROLFILE="/path/to/backend/_synchronize/last.action"
RSYNC_LOGFILE="/path/to/backend/_synchronize/rsync.log"

if [ "${FILE_TO_SYNCHRONIZE_LOCAL}" -nt "${SYNCHRONIZE_CONTROLFILE}" ]

	then

		/usr/bin/true > ${RSYNC_LOGFILE}

		echo "
===================================
		
		"
		
		#
		### ### ###
		#
		# COPY STUFF
		#
		### ### ###
		#
		
		echo $SERVER
		echo "
 Copying rules.ini..."
		
		/usr/bin/rsync -qaulpogtzLK --info=ALL --log-file=${RSYNC_LOGFILE} --delete ${FILE_TO_SYNCHRONIZE_LOCAL} root@${SERVER}:${FILE_TO_SYNCHRONIZE_REMOTE} 2> /dev/null
		if [ $? -eq "0" ]
			then
				echo "
   Success."
				MAIL_SUBJECT="Redirects & Proxies - SUCCESS - rsync report"
			else
				echo "
   !!!  Failed  !!!"
				MAIL_SUBJECT="Redirects & Proxies - ERROR - rsync report"
		fi
		
		echo "
		
===================================
		"
		
		#
		### ### ###
		#
		# SEND EMAIL
		#
		### ### ###
		#
		/usr/bin/cat $RSYNC_LOGFILE >> $SED_TEMPFILE

		(/usr/bin/sed -i "1s/^/$SERVER\n\n/" $SED_TEMPFILE && /usr/bin/cat $SED_TEMPFILE) | /usr/bin/mail -r "nobody@example.com" -s "$MAIL_SUBJECT" $EMAIL_RECIPIENT

		/usr/bin/true > ${SED_TEMPFILE}
		
		/usr/bin/touch ${SYNCHRONIZE_CONTROLFILE}

fi
