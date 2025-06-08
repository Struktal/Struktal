# File structure
Before you start working with the framework and developing your application, it's important to understand the file structure. This will help you find the files that you are looking for.

## Root directory
The root directory contains the following files and subdirectories:
- `📁 .github/` - GitHub Actions workflows
- [`📁 config/`](#config-directory)
- `📁 docker/` - Docker files which are mounted into the image when building it
- `📁 docs/` - Documentation files for the framework (can be deleted or modified)
- [`📁 public/`](#public-directory)
- [`📁 src/`](#src-directory)
- [`📁 struktal/`](#struktal-directory)
- `📁 tests/` - Test files for the framework and for your application
- `📁 template-cache/` - BladeOne template cache files
- `.dockerignore` and `.gitignore`
- `composer.json` - Defines required packages
- `Dockerfile` - Docker file for building the image
- `docker-compose.yml` - Docker compose file for running the image
- `README.md` - Framework README (can be deleted or modified)

### `config` directory
The `📁 config/` directory contains all files that are required for the application to work, but shouldn't be committed to the repository. Files that end with `.dist` are not ignored.

There are the following files and subdirectories:
- `config.json` - Secret application settings or keys
- `config.json.dist` - Example file for `config.json` that can be committed to the repository

### `public` directory
The `📁 public/` directory contains files that are directly accessible via the web server.
Also note that a symlink is created for `📁 public/static/`, which links to the `📁 src/static/` directory, which contains static code, such as CSS, JavaScript, and images.

There are the following files and subdirectories:
- `📁 deployment/` - Files that are required for the automatic deployment of the application
- `.htaccess` - Apache configuration file that redirects all requests to the `📁 public/front-controller.php` file, except for requests to the `📁 public/static/` directory
- `front-controller.php` - PHP script that handles all requests to the web server and redirects them to the correct PHP script in the `📁 src/pages/` directory (see https://en.wikipedia.org/wiki/Front_controller)

### `src` directory
The `📁 src/` directory contains (basically all of) your applications' logic.

There are the following files and subdirectories:
- `📁 config/`
    - `app-config.php` - Basic application settings
    - `app-routes.php` - Routes initialization
- `📁 cronjobs/` - Regularly executed (PHP) scripts
- `📁 lib/` - Custom classes, utilities, etc. for your application
    - `📁 dao/` - DAO classes that are used in your application
    - `📁 object/` - Objects that are used in your application.
    - `📁 schema/` - Database schema files that contain the code which is necessary to (re-)create the database infrastructure (tables, views, triggers, ...)
- `📁 pages/` - PHP script files that are accessible via routes defined in `📁 src/config/app-routes.php`
- `📁 static/` - Static files that are directly accessible via the web server, without any PHP magic
- `📁 templates/` - BladeOne template files that are used to display the page contents
- `📁 translations/` - Translation files for the application

### `struktal` directory
The `📁 struktal/` directory contains all files that are required by the framework itself and your application. If you're working on an application, it's recommended not to edit the files in this directory in order to keep compatibility with newer versions.

There are the following files and subdirectories:
- `📁 config/`
    - `Config.class.php` - Predefined configurable variables and parameters
- `📁 src/` - The frameworks source code
    - `📁 dao/` - Predefined DAO classes for predefined objects
    - `📁 enum/` - Predefined enums
    - `📁 lib/` - Various classes and utilities that are often used in the application code
    - `📁 object/` - Predefined objects that can be used with the data access object pattern
- `📄 start.php` - The primary framework file that imports all necessary files
