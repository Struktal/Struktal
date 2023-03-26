# Documentation
## Logger
A helpful tool for developing and maintaining a project with the framework is it's logger. It allows you to easily write info, error or debug messages into a logfile. To do that, use
```php
Logger::getLogger("NAME")->info("MESSAGE");
Logger::getLogger("NAME")->error("MESSAGE");
Logger::getLogger("NAME")->debug("MESSAGE");
```
<b>Note:</b> The logger is only writing a to the logfile if it's importance is higher than specified in the logger config under ``LOG_LEVEL``.