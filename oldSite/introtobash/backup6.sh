#!/usr/bin/bash

# This is a comment

# The functions used by this program...
function countMessage {
  # Sets the variable COUNTER to 1
  COUNTER=1
  # Sets the variable MAXCOUNTER to whatever 
  #   the first parameter was set to
  MAXCOUNTER=$1
  echo "Backup of the home directory will start in ($MAXCOUNTER seconds): "
  while [  $COUNTER -lt $MAXCOUNTER ]; do
    echo -n "$COUNTER "
    let COUNTER=COUNTER+1
    sleep 1
  done
}

function welcomeMessage {
  /usr/bin/clear
  echo "Welcome to the personal backup system..."
  echo "This will backup all the data in the directory set by the variable \$HOME"
  echo ""
  echo ""
}

# Calls the `welcomeMessage` function 
welcomeMessage

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

# Calls the `countMessage` function with the first
#   argument having a value of 5
countMessage 5

echo ""
echo "tarin' home directory..."
tar -cf /tmp/backup.tar $HOME

echo "gzippin' tar file..."
gzip /tmp/backup.tar

echo "Done."
