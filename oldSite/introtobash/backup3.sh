#!/usr/bin/bash

# This is a comment

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

echo "tarin' home directory..."
tar -cf /tmp/backup.tar $HOME

echo "gzippin' tar file..."
gzip /tmp/backup.tar

echo "Done."
