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

   This is required because all (*) requests withing ``📁 your/directory/`` should be rewritten to ``your/directory/routes-handler.php``.

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
    - ``app-config.php`` - Basic project settings
    - ``app-config.inc.php`` - Project settings that shouldn't be in a git repository
    - ``app-routes.php`` - Routes initialization

5. Now, you can add new scripts inside of the ``📁 project/`` directory.

## How to use
This section provides quick tutorials about how to use the framework and it's features.

If you haven't used the framework before, it's recommended to take a look at the documentation of the <a href="docs/file-structure.md">file structure</a>, <a href="docs/config.md">config</a> and the <a href="docs/logger.md">logger</a> first. It's important to know the file structure to understand the following information and it's helpful to work with the logger to understand what's going on.

<details>
<summary><b>Change basic project settings (name, website title, URL, ...)</b></summary>

You can (and should) change project settings for fresh projects in the ``📁 project/config/app-config.php`` and the `📁 project/config/app-config.inc.php` file. The difference between them is that the ``app-config.inc.php`` file can be ignored by a ``.gitignore``. This makes it possible to store information such as database credentials or other settings that might have been used for testing purposes.

There are the following settings:
- ``PROJECT_SETTINGS``
  - ``PROJECT_NAME`` - The name of your project that is displayed in the header and footer of your website by default
  - ``PROJECT_TITLE`` - The title of your project that is displayed in the browser tab
  - ``PROJECT_URL`` - The URL of your project
  - ``PROJECT_AUTHOR`` - Your name or the name of your company / team that is displayed in the website's footer by default
  - ``PROJECT_VERSION`` - The current version of the project that is displayed in the website's footer by default
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
- ``DATABASE_SETTINGS`` (These settings should be changed in the ``app-config.inc.php`` file)
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

You can set the minimum required log level for a message to be written in the logfile in the ``📁 project/config/app-config.php`` file. The default value is ``INFO``. You can also change the directory where logfiles should be saved in as well as their filename format there. By default, there is one logfile per day.

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
TODO
</details>

<details>
<summary><b>Create a route for a page</b></summary>
TODO
</details>

<details>
<summary><b>Create a sidebar menu item for a page</b></summary>
TODO
</details>

<details>
<summary><b>Create a new object that can be stored in the database</b></summary>
TODO
</details>

<details>
<summary><b>Redirect to other pages or websites</b></summary>
TODO
</details>

<details>
<summary><b>Send JSON responses</b></summary>
TODO
</details>

<details>
<summary><b>Display info, warning, error or success messages</b></summary>
TODO
</details>

<details>
<summary><b>Using the CURL helper class</b></summary>
TODO
</details>

<details>
<summary><b>Using the mail helper class</b></summary>
TODO
</details>

<details>
<summary><b>Using the geolocation helper class</b></summary>
TODO
</details>

<details>
<summary><b>Format and parse datetimes</b></summary>

To ensure uniformity, there is a class called ``DateTimeFormatter`` that can be used to format and parse datetimes. The used format can be changed in the ``📁 project/config/app-config.php`` file.

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
- <a href="docs/geolocation.md">Geolocation</a>
- <a href="docs/date-formatter.md">Date formatter</a>

There's also a documentation for classes that are used internally by the framework:
- <a href="docs/internal/class-loader.md">Class loader</a>

## Contributing
TODO

## License
TODO
