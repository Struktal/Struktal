# PHP-Framework
A powerful and feature-rich PHP framework designed to simplify web development. With built-in support for data access and manipulation, routing and various utilities, this framework makes it easier to handle common web development tasks.

## Contents
1. <a href="#features">Features</a>
2. <a href="#getting-started">Getting started</a>
3. <a href="#how-to-use">How to use</a>
4. <a href="#internal-classes">Internal classes</a>
5. <a href="#contributing">Contributing</a>
5. <a href="#license">License</a>

## Features
- Data access object pattern to simplify database access
- Routing system to redirect requests
- Utility classes for sending CURL requests to e.g. external APIs, 

## Getting started
These instructions will help you to get the framework up and running.

### Prerequisites
- PHP 8.2 or higher
- A web server such as Apache or Nginx
- A database system such as MySQL or MariaDB

### Installing
1. Clone this repository in any directory of the web server:
```console
git clone https://github.com/JensOstertag/PHP-Framework.git .
```

2. If you didn't clone the repository in the root directory but in any Directory (e.g. ``📁 your/directory/``), change the ``RewriteBase`` in  the ``.htaccess`` file from ``📁 /`` to that directory (``/`` -> ``/your/directory/``). If you cloned it in the root directory, you can skip this step.
This is required because all (*) requests withing ``📁 your/directory/`` should be rewritten to ``your/directory/routes-handler.php``.

<sub>* Not all requests within that directory will be rewritten. There's a directory called ``📁 static/`` where direct requests are allowed. It's described in <a href="#file-structure">File structure</a> as to why that is.</sub>

3. In case you want to use git versioning for your project, navigate to the ``project`` directory and initialize a new repository:
```console
git init
```
It's recommeneded to use the following ``.gitignore``-template:
```dockerfile
# Ignore Files that contain sensible Information such as Passwords or secret Keys
/project/config/*.inc.php
```

4. Update the following configuration files within the ``📁 project/config/`` directory. 
    - ``app-config.php`` - Basic project settings
    - ``app-config.inc.php`` - Project settings that shouldn't be in a git repository
    - ``app-routes.php`` - Routes initialization

5. Now, you can add new scripts inside of the ``📁 project/`` directory.

## How to use
This section provides information about how the framework works and about each of the framework's features.

1. <a href="#file-structure">File structure</a>
2. <a href="#logger">Logger</a>
3. <a href="#data-access-object-pattern">Data access object pattern</a>
4. <a href="#router">Router</a>
5. <a href="#comm-class">COMM class</a>
6. <a href="#info--warning--and-error-messages">Info-, warning- and error messages</a>
7. <a href="#curl">Curl</a>
8. <a href="#mail">Mail</a>
9. <a href="#geolocation">Geolocation</a>
10. <a href="#date-formatter">Date formatter</a>

### File structure
The root directory contains the following files and subdirectories:
- <a href="#framework-directory">``📁 framework/``</a>
- <a href="#project-directory">``📁 project/``</a>
- ``.htaccess``
- ``php.ini`` or ``.user.ini``
- ``routes-handler.php``

#### Framework directory
The ``📁 framework/`` directory contains all files that are required by the framework and your project. If you're working on a project, it's recommended not to edit files in this directory in order to keep compatibility with newer versions.

There are the following files and subdirectories:
- ``📁 config/``
    - ``Config.class.php`` - Predefined configurable variables and parameters
- ``📁 src/`` - The primary source code
    - ``📁 dao/`` - Predefined DAO classes for predefined objects
    - ``📁 lib/`` - Libraries of the framework that aren't used often in the framework's code
    - ``📁 object/`` - Predefined objects that can be used with the data access object pattern
    - ``ClassLoader.class.php`` - Class loader
    - ``Comm.class.php`` - Communication class
    - ``Logger.class.php`` - Logger
    - ``Router.class.php`` - Router
    - ``Util.class.php`` - Class with utility functions
- ``framework.php`` - The primary framework file that imports all necessary files

#### Project directory
The ``📁 project/`` directory contains the files for your project.

There are the following files and subdirectories:
- ``📁 config/`` - Configuration files
    - ``app-config.inc.php`` - Project settings that shouldn't be in a git repository
    - ``app-config.php`` - Basic project settings
    - ``app-routes.php`` - Routes initialization
- ``📁 htdocs/`` - Files that are accessible via routes<br>
    This directory should contain the PHP scripts of your project.
    - ``📁 frontend/`` - Files that are used to display the frontend
    - ``📁 static/`` - Files that should be directly accessible<br>
      This directory should be used to store files such as images, stylesheets or frontend scripts. Requests to this directory won't get redirected to ``routes-handler.php`` to allow direct access to these files as they are imported by the frontend.
- ``📁 src/`` - Source code for your project that is used in the ``📁 htdocs/`` directory
  - ``📁 dao/`` - DAO classes that are used in your project
  - ``📁 lib/`` - Additional libraries that are used in your project
  - ``📁 object/`` - Objects that are used in your project

### Logger
A helpful tool for developing and maintaining a project with the framework is it's logger. It allows you to easily write info, error or debug messages into a logfile. To do that, use
```php
Logger::getLogger("NAME")->info("MESSAGE");
Logger::getLogger("NAME")->error("MESSAGE");
Logger::getLogger("NAME")->debug("MESSAGE");
```

The logfile is located in the ``logs`` directory and is labeled with the current date.

### Data access object pattern
TODO

### Router
To add Routes to your project, edit the ``app-routes.php`` file in the ``📁 project/`` directory.

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
It is meant to be located in the ``📁 htdocs/`` directory. As described in <a href="#file-structure">File structure</a>, it can be any file that the user should get displayed (e.g. PHP scripts, HTML sites, ...).
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

### COMM Class
#### Redirect to another page
You can redirect the user to another page by using
```php
Comm::redirect("PATH");
```

#### Send JSON response
You can send the user an individual JSON response by using
```php
Comm::sendJson(DATA);
```
with ``DATA`` being the array that should be JSON-encoded.

#### Send JSON API response
If you're developing an API, you might want to send a status code and message along with the result. This can be achieved easily by using
```php
Comm::apiSendJson(RESPONSE, DATA);
```
Both ``RESPONSE`` AND ``DATA`` are arrays. ``DATA`` holds the main content that should be returned. ``RESPONSE`` holds the status code and message and should be formatted as shown in the following scheme:
```json
{
    "code": STATUS_CODE,
    "message": "STATUS_MESSAGE"
}
```
There are predefined response arrays located in the ``HTTPResponses`` class. It contains the most relevant HTTP responses (``200``, ``201``, ``204``, ``400``, ``401``, ``403``, ``404``, ``405``, ``500``, ``501``, ``503``) that are also common to occur in API usage.

You can use those responses with ``apiSendJson`` like in the following example:
```php
$userDAO = User::dao();
Comm::apiSendJson(HTTPResponses::$RESPONSE_OK, $userDAO->getObjects());
```
This will return roughly the following response (``data`` will hold the information about all users of course):
```json
{
    "code": 200,
    "message": "OK",
    "data": [
        ...
    ]
}
```
<sub>
    <b>Note:</b> You wouldn't want this to be a real API call since it will return <b>ALL</b> information about <b>EVERY</b> user from the database such as real names, password hashes, ...
</sub>

### Info-, warning- and error messages
TODO

### Curl
TODO

### Mail
TODO

### Geolocation
TODO

### Date Formatter
TODO

## Internal classes
There are a few classes that should ideally be used by the framework only. Those classes are documented below.

### Class loader
The class loader used to import a single or all classes within a file or a directory. To do that, use
```php
$classLoader = ClassLoader::getInstance();
$classLoader->loadClass("FILE");
$classLoader->loadClasses("DIRECTORY");
```

## Contributing
TODO

## License
TODO
