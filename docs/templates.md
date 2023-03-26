# Documentation
## Template files
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