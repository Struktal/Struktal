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
It's recommended to use the following ``.gitignore``-template:
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
2. <a href="#config">Config</a>
2. <a href="#logger">Logger</a>
3. <a href="#data-access-object-pattern">Data access object pattern</a>
4. <a href="#router">Router</a>
5. <a href="#comm-class">``Comm`` class</a>
6. <a href="#template-files">Template files</a>
7. <a href="#info-messages">Info messages</a>
8. <a href="#curl">Curl</a>
9. <a href="#mail">Mail</a>
10. <a href="#geolocation">Geolocation</a>
11. <a href="#date-formatter">Date formatter</a>

### File structure
The root directory contains the following files and subdirectories:
- <a href="#framework-directory">``📁 framework/``</a>
- <a href="#project-directory">``📁 project/``</a>
- ``.htaccess``
- ``php.ini`` or ``.user.ini``
- ``routes-handler.php``

#### Framework directory
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

#### Project directory
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

### Config
The framework provides a configuration file that allows you to configure the functions of the framework and your project.

The configuration file (``app-config.php``) is located in the ``📁 project/config/`` directory. It includes the ``app-config.inc.php`` file, where settings that should be ignored in repositories (e.g. database credentials, parameters that are changed for testing purposes, ...) can be overwritten.

You can modify the following settings:
- Project Settings
  - ``PROJECT_NAME`` - The project's name
  - ``WEBSITE_TITLE`` - The title that is displayed for the browser tab
  - ``WEBSITE_URL`` - The project's URL
  - ``PROJECT_AUTHOR`` - The author of the project that is displayed in the footer
  - ``PROJECT_VERSION`` - The version of the project that is displayed in the footer
- Menu Settings
  - ``MENU_SIDEBAR`` - The items shown in the sidebar navigator
- Time Format Settings
  - ``DATE_TECHNICAL`` - The format of a date that is used by the backend
  - ``TIME_TECHNICAL`` - The format of a time that is used by the backend
  - ``DATETIME_TECHNICAL`` - The format of a date and time that is used by the backend
  - ``DATE_VISUAL`` - The format how a date is displayed in the frontend
  - ``TIME_VISUAL`` - The format how a time is displayed in the frontend
  - ``DATETIME_VISUAL`` - The format how a date and time is displayed in the frontend
- Logger Settings
  - ``LOG_DIRECTORY`` - The directory where the logfiles should be stored
  - ``LOG_FILENAME`` - The filename format of a logfile
  - ``LOG_LEVEL`` - The minimum importance that is required for a message to get written into a logfile
- Database Settings
  - ``DB_HOST`` - Database hostname
  - ``DB_USER`` - Database username
  - ``DB_PASSWORD`` - Database password
  - ``DB_NAME`` - Database name
  - ``DB_USE`` - Whether the database should be used or not
- Mail Settings
  - ``MAIL_DEFAULT_SENDER_EMAIL`` - The default sender email address
  - ``MAIL_DEFAULT_SENDER_NAME`` - The default sender name
  - ``MAIL_DEFAULT_REPLY_TO`` - The default reply-to email address
  - ``MAIL_DEFAULT_SUBJECT`` - The default subject of an email
  - ``MAIL_REDIRECT_ALL_MAILS`` - Whether all mails should be redirected to a specific email address for testing purposes
  - ``MAIL_REDIRECT_ALL_MAILS_TO`` - The email address to which all mails should be redirected (if ``MAIL_REDIRECT_ALL_MAILS`` is set to ``true``)
- Class Loader Settings
  - ``CLASS_LOADER_IGNORE_FILES`` - Files that should be ignored by the class loader
  - ``CLASS_LOADER_IMPORT_PATHS`` - Paths that should be imported by the class loader

### Logger
A helpful tool for developing and maintaining a project with the framework is it's logger. It allows you to easily write info, error or debug messages into a logfile. To do that, use
```php
Logger::getLogger("NAME")->info("MESSAGE");
Logger::getLogger("NAME")->error("MESSAGE");
Logger::getLogger("NAME")->debug("MESSAGE");
```

The logfile is located in the ``logs`` directory and is labeled with the current date.

### Data access object pattern
The framework provides a data access object (DAO) pattern that allows you to easily access and manipulate data in a database with objects.

There are objects that represent a table in a database with an objects public attributes as the columns. They're located in the ``📁 project/src/object/`` directory.

Every object is meant to inherit from the ``GenericObject`` class that provides the following generic attributes and their corresponding getter and setter methods:
- ``id`` (integer) - The auto-incremented ID of the object
- ``created`` (datetime) - The date and time when the object was created
- ``updated`` (datetime) - The date and time when the object was last updated
- ``deleted`` (boolean) - Whether the object is deleted or not

For every object class, there's also an own belonging DAO class that is located in the ``📁 project/src/dao/`` directory. The name of the DAO class has to be the same as the object with appended ``DAO`` (example: ``GenericObject`` has the DAO class ``GenericObjectDAO``).

Every DAO is meant to inherit from the ``GenericObjectDAO`` class. This contains the required methods to save and load objects to or from the database. 

<b>Note:</b> A data access object can only be used for objects of it's belonging class, which is also the reason why there needs to be an own DAO class for each object class.

#### Setting up a new object
To set up a new object, you need to create a new class within the ``📁 project/src/object/`` directory. The class name has to be the same as the table name in the database.
```php
class MyObject extends GenericObject {
    public string $myAttribute;
 
    public function getMyAttribute(): string {
        return $this->myAttribute;
    }
    
    public function setMyAttribute(string $myAttribute) : void {
        $this->myAttribute = $myAttribute;
    }
}
```
Next, you'll have to create a new class for the DAO in the ``📁 project/src/dao/`` directory. 

<b>Note:</b> The class name has to be the same as the object class with appended ``DAO``.
```php
class MyObjectDAO extends GenericObjectDAO {
    // Basic DAO methods already implemented by GenericObjectDAO
}
```
If you need to use custom queries or other non-default methods for this specific object, you can implement them in the DAO class.

The above example would allow us to access and manipulate the database table called ``MyObject`` with the following structure:

| ``id``  | ``myAttribute`` | ``created`` | ``updated`` | ``deleted`` |
|---------|-----------------|-------------|-------------|-------------|
| integer | varchar         | datetime    | datetime    | boolean     |

<b>Note:</b> Database tables are not set up automatically, this needs to be done manually.

#### Saving an object to the database
To create a new database entry for an object, you have to create an instance of the object, assign the attributes and save it with the DAO's ``save`` method:
```php
// Create an instance of the object
$myObject = new MyObject();
$myObject->setMyAttribute("Hello World!");

// Save the object to the database
MyObject::dao()->save($myObject);
```
The ``save`` method will automatically set the ``id`` attribute of the object if a new database entry was inserted.

To update an existing database entry, the existing object needs to be modified and saved again:
```php
// Create an instance of the object
$myObject = new MyObject();
$myObject->setMyAttribute("Hello World!");

// Save the object to the database
MyObject::dao()->save($myObject);

// Modify the object
$myObject->setMyAttribute("Hello World! This is an update.");
$myObject->setUpdated(new DateTime());

// Save the object to the database
MyObject::dao()->save($myObject);
```
Instead of creating a new object, you can also <a href="#loading-objects-from-the-database">load an existing object from the database</a> and modify it.

#### Loading objects from the database
To load objects from the database, you can use the DAO's ``getObject`` or ``getObjects`` methods:
```php
// Get the object with the ID 1 if it isn't deleted
$myObject = MyObject::dao()->getObject(array("id" => 1, "deleted" => false));

// Get all objects that aren't deleted
$myObjects = MyObject::dao()->getObjects(array("deleted" => false));
```
For both methods you can set the following parameters:
- ``filters``: An array that contains requirements for the objects that should be returned
- ``orderBy``: A column name that the returned objects should be ordered by
- ``orderAsc``: Whether the returned objects should be ordered ascending or descending
- ``limit``: The maximum amount of objects that should be returned (-1 for no limit)
- ``offset``: The offset from which the objects should be returned

#### Deleting objects from the database
To delete an object from the database, call the objects ``setDeleted`` method with the parameter ``true`` and save it with the DAOs ``save`` method:
```php
// Delete the object with the ID 1
$myObject = MyObject::dao()->getObject(array("id" => 1));
$myObject->setDeleted(true);
$myObject->setUpdated(new DateTime());
MyObject::dao()->save($myObject);
```

### Router
To add routes to your project, edit the ``app-routes.php`` file in the ``📁 project/`` directory.

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
For details about that method'ss abilities, please read the section <a href="#generate-urls">Generate URLs</a> below.

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

This comes in handy specially if you want the URL of a route with may GET parameters. By handing the route's name and the array of parameters that should be bound into the URL, it will return the URI with all GET parameters set.

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

### ``Comm`` Class
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

The returned JSON response will look like this:
```json
{
    "code": STATUS_CODE,
    "message": "STATUS_MESSAGE",
    "data": DATA
}
```
<b>Note:</b> The ``data`` field is a JSON object if the passed ``DATA`` array is an associative array and a JSON array if it is a sequential array.

You can use those responses with ``apiSendJson`` like shown in the following example:
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
Because ``$userDAO->getObjects()`` returns a sequential array, the ``data`` field in the JSON response is a JSON array.<br>
<sub>
    <b>Note:</b> You wouldn't want this to be a real API call since it will return <b>ALL</b> information about <b>EVERY</b> user from the database such as real names, password hashes, ...
</sub>

### Template files
Template files are, in this framework, PHP files that are used to generate the HTML content of the website (you could also add a templating engine such as Twig or Smarty to achieve that).They are located in the ``📁 project/htdocs/frontend/`` directory and are included by the scripts in the ``📁 project/htdocs/`` directory.

To include a template file from a script, use
```php
Template::loadTemplate("TEMPLATE_FILE");
```
with ``TEMPLATE_FILE`` being the template file's name within the ``📁 project/htdocs/frontend/`` directory.

To reduce code duplication and make it easier to maintain the project, you can include another template file within a template file. This comes in handy if you want to include the same header and footer on each page of the website.

To do that, use
```php
Template::includeTemplate("TEMPLATE_FILE");
```
with ``TEMPLATE_FILE`` being the template file's name within the ``📁 project/htdocs/frontend/includes/`` directory.

Because in that case, the website's title would be the same on every page, you can set it individually by using either
```php
Template::setWebsiteTitle("TITLE");
```
which will append the Value defined in the project config under ``WEBSITE_TITLE`` to the passed ``TITLE`` or
```php
Template::overrideWebsiteTitle("TITLE");
```
which will set the website's title only to the passed ``TITLE``.

### Info messages
You can send different info messages to the user by using
```php
new InfoMessage("MESSAGE", InfoMessage::$TYPE_INFO);
new InfoMessage("MESSAGE", InfoMessage::$TYPE_WARNING);
new InfoMessage("MESSAGE", InfoMessage::$TYPE_ERROR);
new InfoMessage("MESSAGE", InfoMessage::$TYPE_SUCCESS);
```
with ``MESSAGE`` being the message that should be displayed.

An info message is stored in the ``$_SESSION`` storage (``$_SESSION["infoMessages"]``) and is displayed by the ``infomessages.php`` Template File on the next page load. Saving the info messages in the ``$_SESSION`` storage allows you to redirect the user to another route without losing them. 

Info messages are automatically removed from the ``$_SESSION`` storage when they're retrieved with ``InfoMessage::getMessages()``. That method also returns the info messages ordered by their type (success, error, warning, info).

### Curl
You can use the ``Curl`` class to send HTTP GET or POST requests to other servers. To do that, use
```php
// GET request to a HTML page
$curl = new Curl();
$curl->setUrl("URL");
$curl->setMethod(Curl::$METHOD_GET);
$curl->addHeader(array(
    "accept" => "text/html, application/xhtml+xml"
));
$response = $curl->execute();
$responseCode = $curl->getHttpCode();
$curl->close();

// POST request to a JSON API 
$curl = new Curl();
$curl->setUrl("URL");
$curl->setMethod(Curl::$METHOD_POST);
$curl->addHeader(array(
    "accept" => "application/json"
));
$curl->addPostData(array(
    "key" => "value"
));
$response = $curl->execute();
$responseCode = $curl->getHttpCode();
$curl->close();
```
with ``URL`` being the URL of the server that you want to send the request to.

### Mail
You can use the ``Mail`` class to send emails. To do that, use
```php
// Initialize the mail object
$mail = new Mail();
$mail->setSenderEmail("SENDER_EMAIL");
$mail->setSenderName("SENDER_NAME");
$mail->setReplyTo("REPLY_TO");
$mail->setSubject("SUBJECT");
$mail->setMessage("MESSAGE");

// Send the mail either as plain text or as HTML
$mail->sendTextMail("RECIPIENT_EMAIL");
$mail->sendHTMLMail("RECIPIENT_EMAIL");
```
with ``SENDER_EMAIL`` being the displayed sender email address, ``SENDER_NAME`` the displayed sender name, ``REPLY_TO`` the email address that should be used as reply-to address, ``SUBJECT`` the mail's subject, ``MESSAGE`` it's body and ``RECIPIENT_EMAIL`` the email address the mail should be sent to.

The mail's body can be formatted as plain text or as HTML. To send it as plain text, use the ``sendTextMail`` method, if you want to send an HTML mail, use the ``sendHTMLMail`` method. The difference between both methods is that the ``sendHTMLMail`` method will add the ``Content-Type: text/html`` header to the mail.

### Geolocation
<b>Legal Note:</b> This library uses the [Nominatim](https://nominatim.org/) API. Please read the [Terms of Use](https://operations.osmfoundation.org/policies/nominatim/) before using it and comply with them.

The geocoding library allows you to get the coordinates of an address or the address of coordinates. To do that, use
```php
// Get coordinates of an address
$geolocation = new Geolocation();
$geolocation->setStreet("Street");
$geolocation->setHouseNumber("House number");
$geolocation->setCity("City");
$geolocation->setZipCode("ZIP code");
$geolocation->setCountry("Country");
$coordinates = $geolocation->getCoordinates();
$lat = $coordinates["latitude"];
$lng = $coordinates["longitude"];

// Get address of coordinates
$geolocation = new Geolocation();
$geolocation->setCoordinates(12.345678, 12.345678);
$address = $geolocation->getAddress();
$street = $address["street"];
$houseNumber = $address["houseNumber"];
$city = $address["city"];
$zipCode = $address["zipCode"];
$country = $address["country"];
$formattedAddress = $geolocation->getFormattedAddress();
```

### Date formatter
The ``DateFormatter`` class is used to format or parse DateTimes. The usage is demonstrated with the ``DATETIME_TECHNICAL`` format, but it is the same for all other formats defined in the date format config. These methods ensure that the date format is always the same and as defined in the config, no matter where it is used.
```php
$datetime = new DateTime();
$formattedDate = DateFormatter::technicalDateTime($datetime);
$parsedDate = DateFormatter::parseTechnicalDateTime($formattedDate);
```

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
