# Jim Young – Drupal Portfolio Site

This is the codebase for my personal portfolio site, built in **Drupal 10** with a Composer-based build process to manage modules and dependencies. The goal of this site is to showcase my experience as a Senior Drupal Developer and Technical Leader across enterprise-scale projects, multilingual builds, API integrations, and accessible, component-based design systems.

## Features

- Fully custom theme using Twig and Drupal’s Layout Builder
- Composer-managed Drupal 10 installation
- Custom blocks and content types to support resume, project portfolio, and blog
- WCAG-compliant templates and styling
- Embedded video support via Vimeo API
- REST API exposure planned for future headless/front-end experimentation
- Hosted on AWS Lightsail with GitHub Actions for CI/CD

## Developer Setup

This project uses Git for version control. To set up a development environment:

```bash
git clone git@github.com:jyoung11/portfolio.git
cd portfolio
composer install
```
## Configure local environment

```bash
git remote set-url origin git@github.com:jyoung11/portfolio.git
git fetch --all
```

---
