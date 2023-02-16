# PHP-Framework
A powerful and feature-rich PHP framework designed to simplify web development. With built-in support for data access and manipulation, routing and various utilities, this framework makes it easier to handle common web development tasks.

## Features
- Data access object pattern to simplify database access
- Routing system to redirect requests
- Utility classes for sending CURL requests to e.g. external APIs, 

## Getting started
These instructions will help you to get the framework up and running.

### Prerequisites
- PHP 8 or higher
- A web server such as Apache or Nginx
- A database system such as MySQL or MariaDB

### Installing
1. Clone this repository in any directory of the web server:
```console
git clone https://github.com/JensOstertag/PHP-Framework.git .
```

2. If you didn't clone the repository in the root directory but in any Directory (e.g. ``your/directory``), change the ``RewriteBase`` in  the ``.htaccess`` file from ``/`` to that directory (``/`` -> ``/your/directory/``). If you cloned it in the root directory, you can skip this step.
This is required because all requests withing ``your/directory`` should be rewritten to ``your/directory/routes-handler.php``.

3. In case you want to use git versioning for your project, navigate to the ``project`` directory and initialize a new repository:
```console
git init
```
It's recommeneded to use the following ``.gitignore``-template:
```dockerfile
# Ignore Files that contain sensible Information such as Passwords or secret Keys
/project/config/*.inc.php
```

4. Update the following configuration files within the ``project/config`` directory. 
    - ``app-config.php`` - Basic project settings
    - ``app-config.inc.php`` - Project settings that shouldn't be in a git repository
    - ``app-routes.php`` - Routes initialization

5. Now, you can add new scripts inside of the ``project`` directory.

## How to use
This section provides information for each of the framework's functions.

### Data Access Object Pattern
TODO

### Router
To add Routes to your project, edit the ``app-routes.php`` file in the ``project`` directory.

To add a route, use
```php
addRoute("HTTP_METHOD", "ROUTE", "TARGET_SCRIPT", "ROUTE_NAME");
```
Replace
- ``HTTP_METHOD``: One or more HTTP methods that prescribe how the route should be accessed.<br>
Multiple HTTP methods have to be separated by a pipe (``|``) character.
- ``ROUTE``: A URI that prescribes how the route should be accessed.
- ``TARGET_SCRIPT``: A target script in the ``htdocs`` directory where the user should get redirected to.
- ``ROUTE_NAME``: A route name that is used by the ``Router::generate`` method.

### Class Loader
TODO

### Logger
TODO

### Comm Class, (HTTPResponses Class)
TODO

### Curl
TODO

### Mail
TODO

### Geolocation
TODO

### Date Formatter
TODO

### Info, Warning and Error Messages
TODO

## Contributing
TODO

## License
TODO
