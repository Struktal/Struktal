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
1. Clone this repository into any directory of the web server (ideally the root directory):
```sh
git clone https://github.com/JensOstertag/PHP-Framework.git .
```

2. If you didn't clone the repository into the root directory but in any other directory (e.g. ``📁 your/directory/``), you have to modify the ``.htaccess`` file as follows:<br>
   - Change the value after ``RewriteBase`` from the default value ``/`` (that stands for your server's root directory) to the directory you cloned the repository into (e.g. ``/your/directory/``).

   This is required because all (*) requests withing ``📁 your/directory/`` should be rewritten to ``📄 your/directory/routes-handler.php``.

   <sub>* Not all requests within that directory will be rewritten. There's a directory called ``📁 static/`` where direct requests are allowed. It's described in the <a href="docs/file-structure.md">file structure documentation</a> as to why that is.</sub>

3. In case you want to use git versioning for your project, remove the current remote and add a new one:
   ```sh
   git remote remove REMOTE
   git remote add REMOTE URL
   ```
   with ``REMOTE`` being the remote's name (much likely ``origin``) and ``URL`` being the URL of the new remote.

   It's recommended to use the following ``.gitignore``-template:
   ```console
   # Ignore Files that contain sensible Information such as Passwords or secret Keys
   /project/config/*.inc.php
   ```
   It's up to you to decide whether or not you want to ignore the framework's files within the ``📁 framework/`` directory.

4. Update the following configuration files in the ``📁 project/config/`` directory: 
    - ``📄 app-config.php`` - Basic project settings
    - ``📄 app-config.inc.php`` - Project settings that shouldn't be in a git repository
    - ``📄 app-routes.php`` - Routes initialization

5. Now, you can add new scripts inside of the ``📁 project/`` directory.

## How to use
This section provides quick tutorials about how to use the framework and it's features.

If you haven't used the framework before, it's recommended to take a look at the documentation of the <a href="docs/file-structure.md">file structure</a>, <a href="docs/config.md">config</a> and the <a href="docs/logger.md">logger</a> first. It's important to know the file structure to understand the following information and it's helpful to work with the logger to understand what's going on.

<details>
<summary><b>Change basic project settings (name, website title, URL, ...)</b></summary>

You can (and should) change project settings for fresh projects in the ``📄 project/config/app-config.php`` and the `📄 project/config/app-config.inc.php` file. The difference between them is that the ``📄 app-config.inc.php`` file can be ignored by a ``.gitignore``. This makes it possible to store information such as database credentials or other settings that might have been used for testing purposes.

There are the following settings:
- ``PROJECT_SETTINGS``
  - ``PROJECT_NAME`` - The name of your project that is displayed in the header and footer of your website by default
  - ``PROJECT_TITLE`` - The title of your project that is displayed in the browser tab
  - ``PROJECT_URL`` - The URL of your project
  - ``PROJECT_AUTHOR`` - Your name or the name of your company / team that is displayed in the website's footer by default
  - ``PROJECT_VERSION`` - The current version of the project that is displayed in the website's footer by default
  - ``PRODUCTION`` - Boolean value that indicates whether the project is in production mode or not (the production mode will load the minified CSS and JS files)
- ``MENU_SETTINGS``
  - ``MENU_ITEMS`` - An array with the following structure of all menu items that should be displayed in the sidebar<br>
    ```php
    [
        "DISPLAY_NAME" => [
            "route" => "ROUTE"
        ],
        // ...
    ]
    ```
- ``DATETIME_SETTINGS``
  - ``DATE_TECHNICAL`` - The format of a date that is used for technical purposes (e.g. in the router)
  - ``TIME_TECHNICAL`` - The format of a time that is used for technical purposes
  - ``DATETIME_TECHNICAL`` - The format of a datetime that is used for technical purposes
  - ``DATE_VISUAL`` - The format of a date that is displayed in the frontend
  - ``TIME_VISUAL`` - The format of a time that is displayed in the frontend
  - ``DATETIME_VISUAL`` - The format of a datetime that is displayed in the frontend
- ``LOG_SETTINGS``
  - ``LOG_DIRECTORY`` - The directory where logfiles are stored
  - ``LOG_FILENAME`` - The filename format of a logfile with ``%date%`` replacing the date
  - ``LOG_LEVEL`` - The minimum log level that is required for a message to be written in the logfile
- ``DATABASE_SETTINGS`` (These settings should be changed in the ``📄 app-config.inc.php`` file)
  - ``DB_HOST`` - The host of the database
  - ``DB_USER`` - The username of the database user
  - ``DB_PASS`` - The password of the database user
  - ``DB_NAME`` - The name of the database
  - ``DB_USE`` - Whether or not the database should is used
- ``MAIL_SETTINGS``
  - ``MAIL_DEFAULT_SENDER_EMAIL`` - The default sender email address
  - ``MAIL_DEFAULT_SENDER_NAME`` - The default sender name
  - ``MAIL_DEFAULT_REPLY_TO`` - The default reply-to email address
  - ``MAIL_DEFAULT_SUBJECT`` - The default subject of an email
  - ``MAIL_REDIRECT_ALL_MAILS`` - Whether or not all mails should be redirected to a specific email address
  - ``MAIL_REDIRECT_ALL_MAILS_TO`` - The email address to which all mails should be redirected
- ``CLASS_LOADER_SETTINGS``
  - ``CLASS_LOADER_IGNORE_FILES`` - An array of files that should be ignored by the class loader
  - ``CLASS_LOADER_IMPORT_PATHS`` - An array of paths that should be included additionally to the default paths
</details>

<details>
<summary><b>Using the logger correctly</b></summary>

It's helpful to use the logger to understand what's going on, whilst developing the project as well as in production. The logger is used to log messages with different log levels. The log levels are the following:
- ``DEBUG``
- ``INFO``
- ``ERROR``

You can set the minimum required log level for a message to be written in the logfile in the ``📄 project/config/app-config.php`` file. The default value is ``INFO``. You can also change the directory where logfiles should be saved in as well as their filename format there. By default, there is one logfile per day.

In the following example you can see how the logger should be used:
```php
<?php
    Logger::getLogger("TAG")->debug("MESSAGE");
    Logger::getLogger("TAG")->info("MESSAGE");
    Logger::getLogger("TAG")->error("MESSAGE");
?>
```
</details>

<details>
<summary><b>Create a new website page</b></summary>

To create a new page for the website, create a new PHP file that should get executed when the user visits the page. The file should be located in the ``📁 project/htdocs/`` directory. There are no limitations what you can do in the script, but it's not recommended to output HTML code or other content directly (exception: you want to send JSON responses, please take a look at the corresponding tutorial or the <a href="docs/comm.md">``Comm`` class documentation</a>). 

Instead, to output content, create a PHP template file in the ``📁 project/htdocs/templates/`` directory. A template file is a normal PHP File that is specialized for outputting content. This separation not only takes care of a better overview, it also separates the logic from the view. For further information about template files, please take a look at the <a href="docs/template.md">template documentation</a>.

Have a look at the following example:

``📄 project/htdocs/example.php``:
```php
<?php

// Assign a variable
$variable = "Hello World!";

// Load the template
Template::display("example.php", array("variable" => $variable));
```
This file is the script that gets executed when the user visits the page. In this example, a variable is assigned and the template ``example.php`` is loaded.

``📄 project/htdocs/frontend/example.php``:
```php
<?php
    // Set the website title and include the header template
    Template::setWebsiteTitle("Title");
    Template::include("header.php");
?>

<?php output($variable); ?>

<?php
    // Include the footer template
    Template::include("footer.php");
?>
```
This is the template file. It sets a website title and includes the header and footer template files located in the ``📁 project/htdocs/frontend/includes/`` directory. The variable that was assigned in the script is then outputted. The ``output`` function is a helper function that is used to output content. It takes care of escaping HTML characters. If there is a need to output unescaped content, the default ``echo`` function can be used instead.

> <b>Note:</b> You could also use [PHP short tags](https://www.php.net/manual/en/language.basic-syntax.phptags.php) within the template file, but make sure that they are enabled in your PHP configuration before doing so.

To learn how to set up a route for your newly created page, take a look at the next tutorial.
</details>

<details>
<summary><b>Create a route for a page</b></summary>

To create a route for a page, you have to add a new entry to the ``📄 project/config/app-routes.php`` file. In that file you can already see some examples and a helper function called ``addRoute`` that registers a new route. The function takes the following parameters:
- ``$method`` - The HTTP method(s) that should be allowed to access the route<br>
  Multiple methods can be specified by separating them with a pipe (``|``) character. For example: ``GET|POST``
- ``$route`` - The URI that should be used to access the route<br>
  GET parameters can be added to the route by using the following syntax: ``{type:name}``<br>
  Supported types are ``b`` (boolean), ``d`` (date (without time)), ``f`` (float), ``i`` (integer) and ``s`` (string).<br>
  The name of the parameter is used to identify the parameter within the ``$_GET`` array.

Assumed you already have a script called ``📄 example.php`` in the ``📁 project/htdocs/`` directory (as described in the previous tutorial about setting up a new page), you can use the following code example to add a route for that page:
```php
<?php
    function addRoute(string $method, string $route, string $routeTo, string $name): void {
        Router::addRoute($method, $route, __DIR__ . "/../htdocs/" . $routeTo, $name);
    }

    // Add the route for the page
    addRoute("GET|POST", "/example", "example.php", "example");
```
This will allow you to access the page with the URI ``/example`` with either the ``GET`` or ``POST`` method.

Note that the ``addRoute`` function doesn't need to be copied as it is already defined in the ``📄 project/config/app-routes.php`` file. It's just shown here for better understanding.

Let's have a look at a more complex example: Assumed you've had a script (``api.php``) that represents an API call that requires passing a ``GET`` parameter called ``id`` of the integer type. You can add a route for this script as shown in the following code:
```php
<?php
    function addRoute(string $method, string $route, string $routeTo, string $name): void {
        Router::addRoute($method, $route, __DIR__ . "/../htdocs/" . $routeTo, $name);
    }

    // Add the route for the page
    addRoute("GET", "/api/{i:id}", "api.php", "api");
```
This will allow you to access the page by the URI ``/api/ID`` with ``ID`` being the integer value of the ``id`` parameter with the ``GET`` method. The ``id`` parameter can then be accessed within the ``📄 api.php`` script by using the ``$_GET`` array like this:
```php
<?php
    $id = $_GET["id"];
    // ...
```
For more information about the ``Router`` class, take a look at the <a href="docs/router.md">router documentation</a>.
</details>

<details>
<summary><b>Create a sidebar menu item for a page</b></summary>

The items in the sidebar menu are defined in the ``📄 project/config/app-config.php`` file in the ``$MENU_SETTINGS["MENU_SIDEBAR"]`` array with the following structure:
```php
[
    "DISPLAY_NAME" => [
        "route" => "ROUTE"
    ],
    // ...
]
```
The ``DISPLAY_NAME`` is the name that is displayed in the sidebar menu. The ``ROUTE`` is the URI that is used to access the page. It's recommended to use the ``Router::generate(String $route)`` method to generate the URI automatically. Have a look at the <a href="docs/router.md">router documentation</a> for more information.

Assumed you've already created a page and a route with the route name ``example`` to that page (as it was described in the corresponding tutorial), you can add a sidebar menu item as follows:
```php
<?php
    // Config settings...
    
    // Add a sidebar menu item for the example page
    $MENU_SETTINGS["MENU_SIDEBAR"]["Example"] = array(
        "route" => Router::generate("example")
    );

    // Config settings...
```
</details>

<details>
<summary><b>Create a new object that can be stored in the database</b></summary>

Creating and modifying entries in the database is done automatically by the implemented data-access-object (DAO) pattern. 

There are so-called "model objects" that represent the data that's being stored in the database, and for each table there is an own model object. They are located in the ``📁 project/src/object/`` directory. 

There's also a data access object interface that defines the standard operations that can be performed on the model objects, such as creating, reading and updating entries. For every model object, there is an own belonging data access object that's located in the ``📁 project/src/dao/`` directory.

To prevent you from having to write the same code over and over again, there are classes called ``GenericObject`` (model object) and ``GenericObjectDAO`` (data access object interface) that every custom object should extend from. The ``GenericObject`` class already implements the table columns
- ``id`` (integer) - The unique identifier of the object
- ``created`` (datetime) - The date and time when the object was created
- ``updated`` (datetime) - The date and time when the object was last updated
- ``deleted`` (boolean) - A flag that indicates whether the object was deleted or not

and the ``GenericObjectDAO`` the standard operations
- ``GenericObjectDAO::save(GenericObject $object)`` to create or update an object's database entry
- ``GenericObjectDAO::getObject(array $filter, string $orderBy, bool $orderAsc, int $limit, int $offset)`` to get a single object from the database
- ``GenericObjectDAO::getObjects(array $filter, string $orderBy, bool $orderAsc, int $limit, int $offset)`` to get multiple objects from the database

Assumed, you want to create a new database table called ``Example`` with the following columns:

| <i>``id``</i> | ``myAttribute`` | <i>``created``</i> | <i>``updated``</i> | <i>``deleted``</i> |
|---------------|-----------------|--------------------|--------------------|--------------------|
| integer       | varchar         | datetime           | datetime           | boolean            |

> <b>Note:</b> The columns ``id``, ``created``, ``updated`` and ``deleted`` are already implemented in the ``GenericObject`` class and don't need to be defined in the custom object, but are required for the database table.

At first, you need to create the table manually as this is not done automatically:
```sql
CREATE TABLE IF NOT EXISTS `Example` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `myAttribute` VARCHAR(255) NOT NULL,
    `created` DATETIME NOT NULL,
    `updated` DATETIME NOT NULL,
    `deleted` tinyint(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
> There is a file ``📄 project/src/schema/tables.sql`` where you can document the SQL statements that are required for your project. This allows you or other persons to easily recreate tables in case you want to set up another instance of your project in the future.

Next, you have to create a class called ``Example`` that extends the ``GenericObject`` class for the model object in the ``📁 project/src/object/`` directory with public attributes named after the exact column names and getter and setter methods to manipulate the data. It's also important to name the class the same as your database table.

``📄 project/src/object/Example.class.php``
```php
<?php
    class Example extends GenericObject {
        public string $myAttribute;
        
        public function getMyAttribute(): string {
            return $this->myAttribute;
        }
        
        public function setMyAttribute(string $myAttribute): void {
            $this->myAttribute = $myAttribute
        }
    }
```

Finally, you have to add the class ``ExampleDAO`` that extends the ``GenericObjectDAO`` class in the ``📁 project/src/dao/`` directory. Here, it's also important to name the class the same as your database table concatenated with ``DAO``. 

``📄 project/src/dao/ExampleDAO.class.php``
```php
<?php
    class ExampleDAO extends GenericObjectDAO {
    
    }
```

For the plain usage of the DAO pattern you don't need to add custom methods as they are already implemented by the ``GenericObjectDAO``. However, if you need methods with custom SQL queries or statements, you should add them in this DAO class.
</details>

<details>
<summary><b>Using data access objects</b></summary>

To create a new database entry for an object, you have to create an instance of the model object, set it's attributes (except for the ``id`` attribute) and save it with the corresponding DAO's ``GenericObjectDAO::save(GenericObject $object)`` method. The ``id`` attribute will be set automatically by the database.

The following example shows how to save a new ``Example`` object that was described in the previous tutorial:
```php
<?php
    // Create a new instance of the Example object
    $example = new Example();
    
    // Set the attributes
    $example->setMyAttribute("Hello World!");
    
    // Save the object to the database
    Example::dao()->save($example);
```

To retrieve objects from the database, you can use the belonging DAO's ``GenericObjectDAO::getObject(array $filter, string $orderBy, bool $orderAsc, int $limit, int $offset)`` or ``GenericObjectDAO::getObjects(array $filter, string $orderBy, bool $orderAsc, int $limit, int $offset)`` method. The difference between both is that the first onne returns a single object and the second one returns an array of found objects. The parameters are the same for both methods:
- ``filters``: An associative array that contains requirements for the objects that should be returned with the column name as key and the value that the column should have as value
- ``orderBy``: A column name that the returned objects should be ordered by
- ``orderAsc``: Whether the returned objects should be ordered ascending or descending
- ``limit``: The maximum amount of objects that should be returned (-1 for no limit)
- ``offset``: The offset from which the objects should be returned

Have a look at the following code examples:
```php
<?php
    // Get all objects that are not deleted
    $examples = Example::dao()->getObjects();
    
    // Get all objects that are deleted
    $examples = Example::dao()->getObjects([
        "deleted" => true
    ]);
    
    // Get the first object that has the attribute "myAttribute" set to "Hello World!"
    // Get the object with the id 42
    $example = Example::dao()->getObject([
        "myAttribute" => "Hello World!"
    ]);
    
    // Get the first 10 objects that are not deleted and have the attribute "myAttribute" set to "Hello World!"
    $examples = Example::dao()->getObjects([
        "myAttribute" => "Hello World!"
    ], "id", true, 10, 0);
    
    // Get the first 10 objects that are not deleted and have the attribute "myAttribute" set to "Hello World!" in descending order by the attribute "myAttribute"
    $examples = Example::dao()->getObjects([
        "myAttribute" => "Hello World!"
    ], "myAttribute", false, 10, 0);
```
> <b>Note:</b> There is a ``deleted`` flag for every object. To prevent you from having to add the ``deleted = false`` filter to every query, both methods automatically add it if not explicitly set to ``false``.

To update an object, you have to retrieve it from the database first and then update it's attributes with the setter methods. After that, you can save the object again with the ``GenericObjectDAO::save(GenericObject $object)`` method. As it is the same object with a set value for the ``id`` attribute, the DAO will update the existing entry instead of creating a new one.
```php
<?php
    // Get the object with the id 42
    $example = Example::dao()->getObject([
        "id" => 42
    ]);
    
    // Update the attribute
    $example->setMyAttribute("Hello World!");
    
    // Save the object to the database
    Example::dao()->save($example);
```
> <b>Note:</b> The ``updated`` attribute is not set automatically.

To delete an object, you would have to update the object with the ``deleted`` attribute set to ``true``:
```php
<?php
    // Get the object with the id 42
    $example = Example::dao()->getObject([
        "id" => 42
    ]);
    
    // Set the deleted attribute
    $example->setDeleted(true);
    
    // Save the object to the database
    Example::dao()->save($example);
```

For more information about the DAO pattern, make sure to read the <a href="docs/dao-pattern.md">DAO documentation</a>.
</details>

<details>
<summary><b>Redirect to other pages or websites</b></summary>

To redirect the user to another page or website, you can use the ``Comm`` class' ``Comm::redirect(String $path)`` method. It sets the ``Location`` header to the given path and stops the execution of the script.

The following example shows how to redirect to another page of your website:
```php
<?php
    Comm::redirect(Router::generate("ROUTE"));
?>
```
It uses the ``Router::generate(String $route)`` method to generate the path to the given route automatically. Have a look at the <a href="docs/router.md">router documentation</a> for more information.

To redirect to another website, you can use the following code example:
```php
<?php
    Comm::redirect("https://www.example.com");
?>
```

</details>

<details>
<summary><b>Send JSON responses</b></summary>

You can send the user an individual JSON response by using
```php
Comm::sendJson(DATA);
```
with ``DATA`` being an array that should be JSON-encoded.

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
> <b>Note:</b> The ``data`` field is a JSON object if the passed ``DATA`` array is an associative array and a JSON array if it is a sequential array.

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
> <b>Note:</b> You wouldn't want this to be a real API call since it will return <b>ALL</b> information about <b>EVERY</b> user from the database such as real names, password hashes, ...
</sub>

For more information, have a look at the <a href="docs/comm.md">``Comm`` class documentation</a>. 
</details>

<details>
<summary><b>Display info, warning, error or success messages</b></summary>

To display info, warning, error or success messages, you can use the ``InfoMessage`` class. It's constructor takes a parameter for the message itself and the message type. The message type is an integer that is defined as static values of the ``InfoMessage`` class.

This is how you can display an info message:
```php
<?php
    // Info message
    new InfoMessage("This is an info message", InfoMessage::INFO);

    // Warning message
    new InfoMessage("This is a warning message", InfoMessage::WARNING);

    // Error message
    new InfoMessage("This is an error message", InfoMessage::ERROR);

    // Success message
    new InfoMessage("This is a success message", InfoMessage::SUCCESS);
```
To prevent unwanted side effects, it's recommended to only send info messages from an executed website script. If you want to send info messages from other scripts.

You might also want to display info messages within JavaScript code. This can be done with the JavaScript ``InfoMessage`` class. It's usage is almost the same as the one in PHP:
```javascript
// Info message
new InfoMessage("This is an info message", InfoMessage.INFO);

// Warning message
new InfoMessage("This is a warning message", InfoMessage.WARNING);

// Error message
new InfoMessage("This is an error message", InfoMessage.ERROR);

// Success message
new InfoMessage("This is a success message", InfoMessage.SUCCESS);
```

As you can modify the DOM within JavaScript, you can also delete / hide info messages. The following example shows how you can delete all info messages displayed by the backend:
```javascript
$(document).ready(() => {
    InfoMessage.clearMessages();
});
```

For more information about the ``InfoMessage`` class, take a look at the <a href="docs/info-messages.md">info message documentation</a>.
</details>

<details>
<summary><b>Using the CURL helper class</b></summary>

You can use the ``Curl`` class to send HTTP GET or POST requests to other servers. The following example code shows how to send a GET request to read an HTML page:
```php
<?php
    $curl = new Curl();
    
    // Define the request and headers
    $curl->setUrl("URL");
    $curl->setMethod(Curl::$METHOD_GET);
    $curl->addHeader(array(
        "accept" => "text/html, application/xhtml+xml"
    ));
    
    // Get the response
    $response = $curl->execute();
    $responseCode = $curl->getHttpCode();
    $curl->close();
```
with ``URL`` being the URL of the server that you want to send the request to.

As a more complex example, let's assume you want to send a POST request to a server that requires a data body. You can do that as follows:
```php
<?php
    $curl = new Curl();
    
    // Define the request and headers
    $curl->setUrl("URL");
    $curl->setMethod(Curl::$METHOD_POST);
    $curl->addHeader(array(
        "accept" => "application/json"
    ));
    
    // Add data to the request
    $curl->addPostData(array(
        "key" => "value"
    ));
    
    // Get the response
    $response = $curl->execute();
    $responseCode = $curl->getHttpCode();
    $curl->close();
```
Here, the ``URL`` is also replaced by the URL of the server that you want to send the request to. 
</details>

<details>
<summary><b>Using the mail helper class</b></summary>

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
</details>

<details>
<summary><b>Using the geocoding helper class</b></summary>

> <b>Legal Note:</b> The geocoding library uses the [Nominatim](https://nominatim.org/) API. Please read the [Terms of Use](https://operations.osmfoundation.org/policies/nominatim/) before using it and comply with them.

You can use the ``Geocoding`` class to get an address' coordinates or coordinates' address:
```php
<?php
    // Get coordinates of an address
    $geocoding = new Geocoding();
    $geocoding->setStreet("Street");
    $geocoding->setHouseNumber("House number");
    $geocoding->setCity("City");
    $geocoding->setZipCode("ZIP code");
    $geocoding->setCountry("Country");
    $coordinates = $geocoding->getCoordinates();
    $lat = $coordinates["latitude"];
    $lng = $coordinates["longitude"];
    
    // Get address of coordinates
    $geocoding = new Geocoding();
    $geocoding->setCoordinates(12.345678, 12.345678);
    $address = $geocoding->getAddress();
    $street = $address["street"];
    $houseNumber = $address["houseNumber"];
    $city = $address["city"];
    $zipCode = $address["zipCode"];
    $country = $address["country"];
    $formattedAddress = $geocoding->getFormattedAddress();
```
</details>

<details>
<summary><b>Format and parse datetimes</b></summary>

To ensure uniformity, there is a class called ``DateTimeFormatter`` that can be used to format and parse datetimes. The used format can be changed in the ``📄 project/config/app-config.php`` file.

To format a datetime to display the current date and time in the frontend, you can use the following code:
```php
<?php
    $datetime = new DateTime();
    $formattedDate = DateFormatter::visualDateTime($datetime);
?>
```

In case you want to format a datetime to a date that should be passed to other components of your project (e.g. a JavaScript file), use the following code:
```php
<?php
    $datetime = new DateTime();
    $formattedDate = DateFormatter::technicalDate($datetime);
?>
```

You can also parse a datetime string to a datetime object:
```php
<?php
    $datetime = new DateTime();
    $formattedDate = DateFormatter::visualDateTime($datetime);
    $newDatetime = DateFormatter::parseVisualDateTime($formattedDate);
?>
```

For an overview of all available methods, please have a look at the <a href="docs/date-formatter.md">documentation</a>.
</details>

<details>
<summary><b>Deploying the application</b></summary>

Before deploying the application, make sure you have enabled the production mode in the ``📄 project/config/app-config.php`` or ``📄 project/config/app-config.inc.php`` file. This will load the minified CSS and JS files. You might also want to change other settings to hide PHP errors and warnings or increase the log level.

Next, minify the CSS and JS files. To do that, execute the following command in the project's root directory:
```bash
./minify.sh
```
> <b>Note:</b> You will need a working installation of a gcc compiler.

> <b>Note:</b> As the minification scripts are selfmade, there might be some problems with the minification process. If you encounter any issues, please open an issue in [this GitHub repository](https://github.com/JensOstertag/MinificationScripts).
> 
> If there are problems, you can either try to find a workaround, minify the files manually (the minified files should be named ``📄 project/htdocs/static/css/style.min.css`` and ``📄 project/htdocs/static/js/script.min.js``) or use the unminified files by disabling the production mode in the ``📄 project/config/app-config.php`` or ``📄 project/config/app-config.inc.php`` file.

Finally, you can upload the project to your web server. The following files and directories should be uploaded:
- ``📁 framework/``
- ``📁 project/``
- ``📄 .htaccess``
- ``📄 .user.ini`` or ``📄 php.ini``
- ``📄 routes-handler.php``
</details>

## Documentation
Learn more about the framework and it's features in the documentation:
- <a href="docs/file-structure.md">File structure</a>
- <a href="docs/config.md">Config</a>
- <a href="docs/logger.md">Logger</a>
- <a href="docs/dao-pattern.md">Data access object pattern</a>
- <a href="docs/router.md">Router</a>
- <a href="docs/comm.md">``Comm`` class</a>
- <a href="docs/templates.md">Template files</a>
- <a href="docs/info-messages.md">Info messages</a>
- <a href="docs/curl.md">Curl</a>
- <a href="docs/mail.md">Mail</a>
- <a href="docs/geocoding.md">Geocoding</a>
- <a href="docs/date-formatter.md">Date formatter</a>

There's also a documentation for classes that are used internally by the framework:
- <a href="docs/internal/class-loader.md">Class loader</a>

<!--## Contributing-->
<!--TODO-->

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
