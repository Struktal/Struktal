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

### File structure
TODO

### Data Access Object Pattern
TODO

### Router
To add Routes to your project, edit the ``app-routes.php`` file in the ``project`` directory.

To add a route, use
```php
addRoute("HTTP_METHOD", "ROUTE", "TARGET_FILE", "ROUTE_NAME");
```
Replace the phrases
- ``HTTP_METHOD``: The HTTP method parameter prescribes with what HTTP methods the route can be accessed.<br>
You can set multiple HTTP methods by separating them with a pipe (``|``) character.
- ``ROUTE``: The route describes with what URI the user should get redirected to the target file.<br>
For more information about how HTTP GET parameters are included in the URI, please read the section <a href="#http-get-parameters">HTTP GET parameters</a> below.
- ``TARGET_FILE``: The target file is the file that the user should get redirected to when he uses the route.<br>
It is meant to be located in the ``htdocs`` directory. As described in <a href="#file-structure">File structure</a>, it can be any file that the user should get displayed (e.g. PHP scripts, HTML sites, ...).
- ``ROUTE_NAME``: The route name is used by the ``Router::generate`` method.<br>
For details about that methods abilities, please read the section <a href="#generate-urls">Generate URLs</a> below.

#### HTTP GET parameters
With this router, HTTP GET parameters cannot be set by adding e.g. ``?key1=value1&key2=value2`` at the end of the URI. Instead, the parameters are strictly included in the route, e.g.: ``/user/<username>/edit``, with "<username>" being replaced as an actual user name.

To achieve that, you can specify GET parameters as 
```
{datatype:key}
```
in a route when you are adding it to the router. The ``datatype`` part prescribes a data type for the parameter. The ``key`` part specifies the name of the parameter and how the value can be accessed from the ``$_GET`` array. Valid data types are:
- ``b`` - Boolean values (``true`` or ``false``)
- ``d`` - Date values (A date formatted as specified in the config under ``DATE_TECHNICAL``)
- ``f`` - Float values
- ``i`` - Integer values
- ``s`` - String values

Therefore, to add the above example route, you would have to use
```php
# We want the route to be accessible by GET and POST methods (GET to access the website, POST to send changes in forms)
# The file that the user should get redirected to is hypothetically called "edit-user.php"
addRoute("GET|POST", "/user/{s:username}/edit", "edit-user.php", "edit-user");
```
The parameter can be accessed in ``edit-user.php`` with
```php
$username = $_GET["username"];
```

#### Generate URLs
The ``Router`` class also offers a method to generate routes that you can add into your PHP script to set button or link redirects or similar.

This comes in handy specially if you want the URL of a route with may GET parameters. By handing the routes name and the array of parameters that should be bound into the URL, it will return the URI with all GET parameters set.

Assumed you have already added the following route:
```php
addRoute("GET|POST", "/user/{s:username}/edit", "edit-user.php", "edit-user");
```
You can get the complete URI with
```php
# Returns "/user/<username>/edit"
Router::generate("edit-user", array(
    "username" => "<username>"
));
```
and add it to an ``<a>`` tag in the users profile.

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
