#!/bin/sh
#
# Cloud Hook: post-code-deploy
#
# The post-code-deploy hook is run whenever you use the Workflow page to 
# deploy new code to an environment, either via drag-drop or by selecting
# an existing branch or tag from the Code drop-down list. See 
# ../README.md for details.
#
# Usage: post-code-deploy site target-env source-branch deployed-tag repo-url 
#                         repo-type

site="$1"
target_env="$2"
source_branch="$3"
deployed_tag="$4"
repo_url="$5"
repo_type="$6"

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
