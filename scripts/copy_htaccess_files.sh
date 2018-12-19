#!/usr/bin/env bash
 
SUB_ENV_NAME=$1;
FILE_NAME=$2;
echo $SUB_ENV_NAME;

drush rsync -y $SUB_ENV_NAME:.htaccess files/$FILE_NAME; 
dos2unix files/$FILE_NAME;
chmod -R 777 files/$FILE_NAME;
#echo 'Remove all files in files folder';
#rm -r files/*;
#echo 'Done'
