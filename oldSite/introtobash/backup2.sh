#!/usr/bin/bash
echo "tarin' home directory..."
tar -cf /tmp/backup.tar $HOME

echo "gzippin' tar file..."
gzip /tmp/backup.tar

echo "Done."
