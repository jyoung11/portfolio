#!/bin/sh
#
# Cloud Hook: post-code-update
#
# The post-code-update hook runs in response to code commits.
# When you push commits to a Git branch, the post-code-update hooks runs for
# each environment that is currently running that branch. See
# ../README.md for details.
#
# Usage: post-code-update site target-env source-branch deployed-tag repo-url
#                         repo-type

site="$1"
target_env="$2"
source_branch="$3"
deployed_tag="$4"
repo_url="$5"
repo_type="$6"


if [ "$target_env" != 'prod' ]; then
    echo "#------------------------------------------------------------------#"
    echo ""
    echo "$site.$target_env: The $source_branch branch has been updated on $target_env."

    # Execute Drupal database update
    echo "Updating Drupal Database using command 'drush9 $site.$target_env updatedb --yes --strict=0' "
    drush9 @$site.$target_env updatedb --yes --strict=0


    echo ""
    echo "#------------------------------------------------------------------#"
    echo ""

    # Execute Drupal cache rebuild.
    echo "Clearing the Drupal cache..."
    drush @$site.$target_env cr

    echo ""
    echo "#------------------------------------------------------------------#"

else
    echo "#------------------------------------------------------------------#"
    echo "    $site.$target_env: The $source_branch branch has been updated on $target_env."
    echo "#------------------------------------------------------------------#"
fi
