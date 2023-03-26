# Documentation
## File structure
The root directory contains the following files and subdirectories:
- <a href="#framework-directory">``📁 framework/``</a>
- <a href="#project-directory">``📁 project/``</a>
- ``.htaccess``
- ``php.ini`` or ``.user.ini``
- ``routes-handler.php``

### Framework directory
The ``📁 framework/`` directory contains all files that are required by the framework itself and your project. If you're working on a project, it's recommended not to edit the files in this directory in order to keep compatibility with newer versions.

There are the following files and subdirectories:
- ``📁 config/``
  - ``Config.class.php`` - Predefined configurable variables and parameters
- ``📁 src/`` - The primary source code
  - ``📁 dao/`` - Predefined DAO classes for predefined objects
  - ``📁 lib/`` - Libraries of the framework that aren't used often in the frameworks code
  - ``📁 object/`` - Predefined objects that can be used with the data access object pattern
  - ``ClassLoader.class.php`` - Class loader
  - ``Comm.class.php`` - Communication class
  - ``Logger.class.php`` - Logger
  - ``Router.class.php`` - Router
  - ``Util.class.php`` - Class with utility functions
- ``framework.php`` - The primary framework file that imports all necessary files

### Project directory
The ``📁 project/`` directory contains the files for your project.

There are the following files and subdirectories:
- ``📁 config/`` - Configuration files
    - ``app-config.inc.php`` - Project settings that shouldn't be in a git repository
    - ``app-config.php`` - Basic project settings
    - ``app-routes.php`` - Routes initialization
- ``📁 htdocs/`` - Files that are accessible via routes<br>
  This directory should contain the PHP scripts of your project.
    - ``📁 frontend/`` - PHP template files that are used to display the frontend
    - ``📁 static/`` - Files that should be directly accessible<br>
      This directory should be used to store files such as images, stylesheets or frontend scripts. Requests to this directory won't get redirected to ``routes-handler.php`` to allow direct access to these files as they are imported by the frontend.
    - PHP scripts that are accessible via routes
- ``📁 src/`` - Source code for your project that is used in the ``📁 htdocs/`` directory
    - ``📁 dao/`` - DAO classes that are used in your project
    - ``📁 lib/`` - Additional libraries that are used in your project
    - ``📁 object/`` - Objects that are used in your project