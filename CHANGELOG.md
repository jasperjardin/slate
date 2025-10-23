#### 2.1.1 (2025-04-29)

* Fix bug with enqueuing pattern CSS for WP 6.8
* Enqueue ACF CSS in block_editor_assets as a temporary fix for their bug with patterns. This shouldn't have repercussions once ACF resolves the issue.
* Remove margins from a few blocks in the editor view.

### 2.1.0 (2025-04-23)

* Add search page & add new fields/functionality to post filters archive.
* Add rules for Cursor. These will need to change over time and can be used for any AI IDE
* Add breadcrumbs block
* Move media into a block & component. Refactor Content & Media Split to use the Media block.
* Add block limits to Content Split
* Upgrade PHPCS and implement new WP standards
* Add Wistia video support
* Add helpers function `get_block_partial` in instances that we need to create a block partial instead of a component (top level items under page-content).
* Force noindex, nofollow on module library
* Fix bug with webpack where it would pull the previous block.json files causing errors when a block is deleted

## 2.0.0 (2025-01-23)

* Removed yarn, use npm instead
* Upgrade node from 20 -> 22
* Upgrade all packages to a secure version. Most notable change it so Sass.
* Add content media split module, replacing image & content split.
* Fix bug with displayed author

#### 1.0.0 (2025-01-09)

Changelog introduced.
