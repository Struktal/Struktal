# Documentation
## Template files
This framework uses template files to separate view and logic, which ensures maintainability of the project. Specifically, it uses the [BladeOne library](https://github.com/EFTEC/BladeOne), which is based off the Blade template engine. There are the following types of template files:
- **Views**: These are the main template files that are included by the scripts in the ``📁 project/htdocs/`` directory. They are located in the ``📁 project/htdocs/frontend/`` directory. Each file represents a page of the website.
- **Components**:: These are template files that are included by the views. They are located in the ``📁 project/htdocs/frontend/components/`` directory and are used to extract common parts of the website, such as the application shell with headers and footers, but can also be used for more specific parts of the website, such as forms, tables, etc.

To learn about how to use the templating engine, please refer to the [BladeOne documentation](https://github.com/EFTEC/BladeOne/blob/master/README.md).
