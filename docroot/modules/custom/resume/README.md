# Resume Module

This module provides a reusable, installable **Resume** content type for Drupal 11 with field groups, paragraph types, and flexible content sections.

## 🧩 Features

- Resume content type with tabbed field group UI
- Modular paragraph types:
  - **Highlights**: expandable case studies or achievements
  - **Work Experience**: company, title, dates, accomplishments
  - **Education**: school, location, degree, graduation date
- Rich text fields with Full HTML editing
- Media and file support
- Custom section headers for Summary and Skills
- Multilingual and accessible-ready config

## 📦 Installation

1. Copy the `resume` module to your `modules/custom/` directory
2. Enable the module:
   ```bash
   drush en resume
   ```
3. (Optional) Rebuild caches:
   ```bash
   drush cr
   ```

## 🧪 Testing
Create a new **Resume** node and test all form tabs. Paragraphs can be added and reordered. Media and file uploads are supported.

## 📁 Structure

```
resume/
├── config/
│   └── install/         # Full YAML config for content type, paragraphs, and displays
├── resume.info.yml
├── README.md
```

## 💡 Ideas for Extension
- Export to PDF
- JSON:LD markup
- Views integration for public profile browsing

## 🛠 Requirements
- Drupal 11
- Media module
- Paragraphs module
- Field Group module

---

MIT License. Developed by [Jim Young].