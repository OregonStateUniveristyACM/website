#!/usr/bin/bash

# This is a comment

# This is a variable
COUNTER=1
MAXCOUNTER=10

# check to see if the backup.tar exists
if [ -e /tmp/backup.tar ]; then
  echo "backup.tar file exists, please deal with it before continuing."
  exit
fi

# check to see if the backup.tar.gz file exists
if [ -e /tmp/backup.tar.gz ]; then
  echo "backup.tar.gz file exists, please deal with it before continuing."
  exit
fi

echo "Backup of the home directory will start in ($MAXCOUNTER seconds): "
while [  $COUNTER -lt $MAXCOUNTER ]; do
  echo -n "$COUNTER "
  let COUNTER=COUNTER+1 
  sleep 1
done

echo ""
echo "tarin' home directory..."
tar -cvf /tmp/backup.tar $HOME > /tmp/tar_output.txt

echo "gzippin' tar file..."
gzip -v /tmp/backup.tar >> /tmp/gzip_output.txt

echo "Done."
