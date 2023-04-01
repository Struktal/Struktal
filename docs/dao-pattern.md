# Documentation
## Data access object pattern
The framework provides a data access object (DAO) pattern that allows you to easily access and manipulate data in a database with objects.

There are objects that represent a table in a database with an objects public attributes as the columns. They're located in the ``📁 project/src/object/`` directory.

Every object is meant to inherit from the ``GenericObject`` class that provides the following generic attributes and their corresponding getter and setter methods:
- ``id`` (integer) - The auto-incremented ID of the object
- ``created`` (datetime) - The date and time when the object was created
- ``updated`` (datetime) - The date and time when the object was last updated
- ``deleted`` (boolean) - Whether the object is deleted or not

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

### Setting up a new object
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

The database tables need to be set up manually. Use the following template to do that:
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

### Saving an object to the database
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

### Loading objects from the database
To load objects from the database, you can use the DAO's ``getObject`` or ``getObjects`` methods:
```php
// Get the object with the ID 1 if it isn't deleted
$myObject = MyObject::dao()->getObject(array("id" => 1, "deleted" => false));

// Get all objects that aren't deleted
$myObjects = MyObject::dao()->getObjects(array("deleted" => false));
```
For both methods you can set the following parameters:
- ``filters``: An associative array that contains requirements for the objects that should be returned with the column name as key and the value that the column should have as value
- ``orderBy``: A column name that the returned objects should be ordered by
- ``orderAsc``: Whether the returned objects should be ordered ascending or descending
- ``limit``: The maximum amount of objects that should be returned (-1 for no limit)
- ``offset``: The offset from which the objects should be returned

> <b>Note:</b> As there is a ``deleted`` flag for every object, you should always set the ``deleted`` filter to ``false`` to only retrieve objects that aren't deleted, except of course you want to retrieve deleted objects.

### Deleting objects from the database
To delete an object from the database, call the objects ``setDeleted`` method with the parameter ``true`` and save it with the DAOs ``save`` method:
```php
// Delete the object with the ID 1
$myObject = MyObject::dao()->getObject(array("id" => 1));
$myObject->setDeleted(true);
$myObject->setUpdated(new DateTime());
MyObject::dao()->save($myObject);
```
> <b>Note:</b> You might notice that you can delete an object by setting the ``deleted`` flag to ``true``, which doesn't actually delete the database entry. This is done to allow undoing the deletion of an object. However, this enforces you to only retrieve objects that aren't deleted.