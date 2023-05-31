# Documentation

## CSV reader
The CSV reader allows you to read CSV files and convert them to arrays. To do that, use the ``CSVReader`` class as shown below:

```php
$csvReader = new CSVReader();

// CSV reader options
$csvReader->setFile("path/to/file.csv")
$csvReader->setDelimiter(";")
$csvReader->setMaxLineLength(null)
$csvReader->read();

// Get the CSV data
$data = $csvReader->getData();
```

The ``read()`` method reads the CSV file and converts it to an array that is stored in the object. The ``getData()`` method returns the array that was created by the ``read()`` method.

This is done because the ``CSVReader`` class follows the Builder pattern. This means that you could also chain the methods from the above example.

### CSV reader options
The CSV reader has the following options:

#### ``setFile(string $file)``
Set the path to the CSV file that should be read. This option is required.

#### ``setDelimiter(string $delimiter)``
Set the delimiter that is used in the CSV file. This option is required to read the CSV file correctly. The default value is ``,`` as it is the default delimiter in Excel.

#### ``detectDelimiter(string $delimiter)``
Detect the delimiter that is used in the CSV file. This option can be used instead of ``setDelimiter()`` when it's not known which delimiter is used in the CSV file. The method uses the first line of the CSV file to detect which character of ``,``, ``;``, ``\t`` or ``|`` occurs most often.

#### ``setMaxLineLength(int $maxLineLength)``
Set the maximum length of a line in the CSV file. If no value is set, the maximum length is unlimited.
