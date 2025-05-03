#!/bin/sh
#
# Cloud Hook: drush-cache-clear
#
# Run drush cache-clear all in the target environment. This script works as
# any Cloud hook.


# Map the script inputs to convenient names.
site=$1
target_env=$2
drush_alias=$site'.'$target_env

# Execute a standard drush command.
echo "#------------------------------------------------------------------#"
echo "    $site.$target_env: Clearing the Drupal cache..."
drush @$drush_alias cr
echo "    Drupal Cache cleared on $site.$target_env"
echo "#------------------------------------------------------------------#"