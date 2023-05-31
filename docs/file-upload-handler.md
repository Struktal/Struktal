# Documentation

## File upload handler
PHP stores uploaded files in the ``$_FILES`` array. However, this array is not very trivial to use for multiple file uploads. The ``FileUploadHandler`` class provides an easy way to check whether a file upload should be allowed and to get the files in a more convenient way.

As an example, let's assume you'd have a form that allows a file upload:
```html
<form method="post" enctype="multipart/form-data">
    <input type="file" name="fileInputName" id="file">
    <input type="submit" value="Upload">
</form>
```

Note that the file input has the name ``fileInputName`` which will be important to the file upload handler.

To check whether the file upload should be allowed and to get the uploaded files, use the ``FileUploadHandler`` class as shown below:
```php
$fileUploadHandler = new FileUploadHandler();

// File upload options
$fileUploadHandler->setInputName("fileInputName");
$fileUploadHandler->setMultiple(false);
$fileUploadHandler->setAllowedMimeTypes(["image/jpeg", "image/png"]);
$fileUploadHandler->setMaxSize(2);
$fileUploadHandler->handleUpload();

// Check if there were errors during the upload
if(!($fileUploadHandler->successful())) {
    $errors = $fileUploadHandler->getErrors();
    return;
}

// Get the uploaded files
$uploadedFiles = $fileUploadHandler->getUploadedFiles();
```

From then on, you can use the ``$uploadedFiles`` array and do whatever you want with the uploaded files (store them permanently, use them temporarily in the script, ...).

The ``handleUpload()`` method checks whether the file upload should be allowed and stores the uploaded files in the object. The ``successful()`` method returns ``true`` if there were no errors during the file upload or ``false`` if there was at least one error. The ``getErrors()`` method returns an array of ``FileUploadErrors`` that occurred during the upload. The ``getUploadedFiles()`` method returns an array the uploaded files, structured as follows:
```php
[
    [0] => [
        "name" => "file2.jpeg",
        "type" => "image/jpeg",
        "tmp_name" => "/tmp/php/php1h4j1o",
        "error" => 0,
        "size" => 1024
    ],
    [1] => [
        "name" => "file2.jpg",
        "type" => "image/jpeg",
        "tmp_name" => "/tmp/php/php6hst32",
        "error" => 0,
        "size" => 1024
    ],
    // ...
]
```

### File upload options
The file upload handler has the following options:

#### ``setInputName(string $inputName)``
Set the name of the file input. This option is required as it is used to retrieve the uploaded files from the ``$_FILES`` array.

#### ``setMultiple(bool $multiple)``
Set whether multiple file uploads should be allowed. The default value is ``false``.

#### ``setAllowedMimeTypes(array $allowedMimeTypes)``
Set the allowed MIME types for the file upload. The default value is ``[]`` which means that no type is allowed and therefore all file uploads will be rejected. The MIME types should be specified as an array of strings.

#### ``setMaxSize(int $maxSize)``
Set the maximum size of the file upload in mebibytes. If no value is set, the maximum size is unlimited.
