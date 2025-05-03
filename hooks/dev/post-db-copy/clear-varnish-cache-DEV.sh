#!/bin/sh
#
# Cloud Hook: drush-cache-clear
#
# Run drush cache-clear all in the target environment. This script works as
# any Cloud hook.


# Map the script inputs to convenient names.
site="$1"
target_env="$2"
source_branch="$3"
deployed_tag="$4"
repo_url="$5"
epo_type="$6"

# Execute a standard drush command.
# drush @$site.$target_env  ac-domain-purge <ACQUIA-SITE-NAME>.prod.acquia-sites.com
# echo "#------------------------------------------------------------------#"
# echo "    $site.$target_env: Cleared Varnish in DEV for domain name:"
# echo "      <ACQUIA-SITE-NAME>.prod.acquia-sites.com"
# echo "#------------------------------------------------------------------#"