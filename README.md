# Slate Future-Proof WordPress Theme

## Table of Contents
1. [Overview](#overview)
2. [Folder Structure](#folder-structure)
3. [Dependencies](#dependencies)
4. [Setup and Installation](#setup-and-installation)
5. [Tasks](#tasks)
   - [ACF Blocks](#acf-blocks)
   - [Components](#components)
   - [Building CSS/JS](#building-css-js)
   - [Using BrowserSync](#using-browsersync)
6. [Testing](#testing)
7. [VSCode Plugins](#vscode-plugins)
8. [Changelog & Releases](#changelog)

---

## Overview <a name="overview"></a>

A clean-code powerhouse built with OOP and enforced by the best linting tools. Scalable, maintainable, Gutenberg theme, and featuring Laravel Blade templating—this is the modern standard for WordPress development.

---

## Folder Structure <a name="folder-structure"></a>

```
.vscode/          # VS Code-specific configurations.
acf-blocks/       # ACF Gutenblocks.
acf-json/         # ACF field groups synced automatically.
assets/vendor     # Third-party vendor files and 3rd party libraries and scripts that are manually managed.
assets/images     # Media files that don't require a build process (images etc).
assets/resources/ # Source files (SCSS, JS, icons, etc.)
components/       # Reusable UI components that can enqueue their own CSS/JS when used.
includes/         # PHP files and functions for backend logic. PHP files in the folder are automatically included.
tasks/            # Task automation scripts (e.g., gulp, webpack).
```

---

## Dependencies <a name="dependencies"></a>

1. Node 22.x
2. Composer
3. PHP 8.2+

---

## Setup and Installation <a name="setup-and-installation"></a>

1. Clone the repository:
   ```
   git clone <repository-url>
   cd impulse-wp
   ```

2. Install dependencies:
   ```
   npm run setup
   ```

3. Set up the environment file:
   ```
   cp .env.sample .env
   code .env
   ```

4. Build assets for development (BrowserSync):
   ```
   npm run build
   npm run serve  # (serve doesn't build assets before watching)
   ```

5. Build assets for production:
   ```
   npm run build --prod
   ```

---

## Tasks <a name="tasks"></a>

### ACF Blocks <a name="acf-blocks"></a>

ACF Blocks are used by the Gutenberg editor.

#### Create a new block

Run `npm run block-add` to create a new ACF block.
**Note**: Make sure the category you use exists or create a new one to match it, or else the block won't show up in the backend.

---

### Components <a name="components"></a>

Reusable UI modules used throughout the theme.

#### Create a new component

Run `npm run component-add` to create a new component.

Components are used like template parts but will automatically enqueue scripts/styles associated with them. Output your components with `get_component( $name, $args )`.

---

### Building CSS/JS <a name="building-css-js"></a>

```
npm run build
npm run watch
npm run styles
npm run scripts
```

Add the `--prod` parameter to any command to compile a production-ready version. Before deploying, run `npm run build --prod`.

---

### Using BrowserSync <a name="using-browsersync"></a>

This will trigger your browser to reload when changes are made to the theme.

1. Copy `.env.example` to `.env`:
   ```
   cp .env.example .env
   ```

2. Change the `APP_URL` to your local site.

3. Run `npm run serve`.

---

## Testing <a name="testing"></a>

The commands below will test the entire project:

```
npm run test       # Tests PHP/JS/SCSS files.
npm run phpcs      # Tests for PHP errors.
npm run phpcbf     # Fixes any fixable PHP errors.
npm run eslint     # Tests and fixes JS errors.
npm run stylelint  # Tests and fixes SCSS errors.
```

---

## VSCode Plugins <a name="vscode-plugins"></a>

While you can use any editor, we highly recommend VSCode. To take advantage of the settings provided, create a workspace including this repository and install the following plugins:

1. ESLint
2. Stylelint
3. PHP Sniffer & Beautifier (Samuel Hilson)
4. EditorConfig for VS Code

---

## Changelog & Releases <a name="changelog"></a>

View the changelog by opening the CHANGELOG.md file.

To create a new release:

1. Add a new entry to the changelog
   ```
   npm run changelog:<patch|minor|major>
   ```

2. Review the changelog and make adjustments as needed. Then create a commit.
   ```
   git add CHANGELOG.md && git commit -m 'updated CHANGELOG.md'
   ```

3. Version git/package.json
   ```
   npm version <patch|minor|major>.
   ```

4. Push changes & new tag to origin
   ```
   git push origin && git push origin --tags
   ```

---
