# Documentation
## Template files
Template files are, in this framework, PHP files that are used to generate the HTML content of the website (you could also add a templating engine such as Twig or Smarty to achieve that). They are located in the ``📁 project/htdocs/frontend/`` directory and are included by the scripts in the ``📁 project/htdocs/`` directory.

To simply include a template file from a script, use
```php
Template::display("TEMPLATE_FILE");
```
with ``TEMPLATE_FILE`` being the template file's name within the ``📁 project/htdocs/frontend/`` directory.

If you want to use variables that are defined in the script in the template file, you have to pass them as an associative array to the ``display()`` method. For example, if you want to use the variable ``$title`` in the template file, you would use
```php
Template::display("TEMPLATE_FILE", array("title" => $title));
```
and in the template file, you would use
```php
<?php echo $title; ?>
```
The keys of the array are the variable names that you want to use in the template file and the values are the values that are assigned to the variables.

To reduce code duplication and make it easier to maintain the project, you can include another template file within a template file. This comes in handy if you want to include the same header and footer on each page of the website.

To do that, use
```php
Template::include("TEMPLATE_FILE");
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