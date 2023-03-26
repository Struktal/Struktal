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

<sub>* Not all requests within that directory will be rewritten. There's a directory called ``📁 static/`` where direct requests are allowed. It's described in the <a href="docs/file-structure.md">file structure documentation</a> as to why that is.</sub>

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
This section provides quick tutorials about how to use the framework and it's features.

If you haven't used the framework before, it's recommended to take a look at the documentation of the <a href="docs/file-structure.md">file structure</a>, <a href="docs/config.md">config</a> and the <a href="docs/logger.md">logger</a> first. It's important to know the file structure to understand the following information and it's helpful to work with the logger to understand what's going on.

<details>
<summary><b>Change basic project settings (name, website title, URL, ...)</b></summary>
TODO
</details>

<details>
<summary><b>Using the logger correctly</b></summary>
TODO
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
TODO
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
