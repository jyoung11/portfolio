# Portfolio site built on Drupal 10 Hosted on AWS Lightsail

The Drupal 10 install uses a Composer build process to manage modules and dependencies.

This codebase uses Git as the origin. The remote list for developers should look like this:

`git remote -v` should output:
```
origin  git@github.com:jyoung11/portfolio.git (fetch)
origin  git@github.com:jyoung11/portfolio.git (push)
```

To reconfigure developer workstation environments please use the following: commands:

```
git remote set-url origin git@github.com:jyoung11/portfolio.git
```

Then fetch all branch info from the new remote origin at GitHub and pull changes to synchronize environment.
