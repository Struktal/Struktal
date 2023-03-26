# Documentation
## Info messages
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