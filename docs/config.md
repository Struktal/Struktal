# Documentation
## Config
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
    - ``DB_PASS`` - Database password
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