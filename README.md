# (add)ventures Portfolio Hub site built on Drupal 8 hosted on Acquia Cloud

The Drupal 8 install uses a Composer build process to manage modules and dependencies.

This codebase uses Git as the origin remote and Acquia Cloud as a secondary deploy remote. The remote list for developers should look like this:

`git remote -v` should output:
```
acquia  addhub@svn-2625.devcloud.hosting.acquia.com:addhub.git (fetch)
acquia  addhub@svn-2625.devcloud.hosting.acquia.com:addhub.git (push)
origin  git@github.com:addventures-engineering/add-hub.git (fetch)
origin  git@github.com:addventures-engineering/add-hub.git (push)
```

To reconfigure developer workstation environments please use the following: commands:

```
git remote add acquia addhub@svn-2625.devcloud.hosting.acquia.com:addhub.git
```

and

```
git remote set-url origin git@github.com:addventures-engineering/add-hub.git
```

Then fetch all branch info from the new remote origin at GitHub and pull changes to synchronize environment.
