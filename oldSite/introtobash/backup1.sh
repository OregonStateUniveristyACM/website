#!/usr/bin/bash
tar -cf /tmp/backup.tar $HOME
gzip /tmp/backup.tar
