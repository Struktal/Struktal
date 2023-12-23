# Documentation
## File structure
The root directory contains the following files and subdirectories:
- `📁 .github/` - GitHub Actions workflows
- `📁 docker/` - Docker files which are mounted into the image when building it
- `📁 docs/` - Documentation files for the framework (can be deleted or modified)
- [`📁 framework/`](#framework-directory)
- [`📁 htdocs/`](#htdocs-directory)
- [`📁 project/`](#project-directory)
- [`📁 secrets/`](#secrets-directory)
- `.dockerignore` and `.gitignore`
- `composer.json` - Defines required packages
- `Dockerfile` - Docker file for building the image
- `docker-compose.yml` - Docker compose file for running the image
- `README.md` - Framework README (can be deleted or modified)

### Framework directory
The `📁 framework/` directory contains all files that are required by the framework itself and your project. If you're working on a project, it's recommended not to edit the files in this directory in order to keep compatibility with newer versions.

There are the following files and subdirectories:
- `📁 config/`
  - `Config.class.php` - Predefined configurable variables and parameters
- `📁 src/` - The frameworks source code
  - `📁 dao/` - Predefined DAO classes for predefined objects
  - `📁 lib/` - Libraries of the framework that aren't used often in the frameworks code
  - `📁 object/` - Predefined objects that can be used with the data access object pattern
- `framework.php` - The primary framework file that imports all necessary files

### htdocs directory
The `📁 htdocs/` directory contains all files that are directly accessible via the web server.

There are the following files and subdirectories:
- `📁 deployment/` - Files that are used for the automatic deployment of the project
- `📁 static/` - Static files that are used in the frontend, such as CSS, JavaScript and images
- `.htaccess` - Apache configuration file that redirects all requests to the `📁 htdocs/routes-handler.php` file, except for requests to the `📁 htdocs/static/` directory
- `routes-handler.php` - PHP script that handles all requests to the web server and redirects them to the correct PHP script in the `📁 project/htdocs/` directory

### Project directory
The `📁 project/` directory contains most PHP files of your project.

There are the following files and subdirectories:
- `📁 config/`
  - `app-config.php` - Basic project settings
  - `app-routes.php` - Routes initialization
- `📁 frontend/` - PHP template files that are used to display the frontend
- `📁 htdocs/` - PHP script files that are accessible via routes defined in `📁 project/config/app-routes.php`
- `📁 src/` - Source code for your project that can be used in the `📁 project/htdocs/` directory
    - `📁 dao/` - DAO classes that are used in your project
    - `📁 lib/` - Additional libraries that are used in your project
    - `📁 object/` - Objects that are used in your project. Composer packages are installed in this directory.
    - `📁 schema/` - Database schema files that contain the code which is necessary to (re-)create the database infrastructure (tables, views, triggers, ...)

### Secrets directory
The `📁 secrets/` directory contains all files that are required for the project to work, but shouldn't be committed to the repository. Files that end with `.example` are not ignored.

There are the following files and subdirectories:
- `config.secret.json` - Secret project settings or keys
- `config.secret.json.example` - Example file for `config.secret.json` that can be committed to the repository
