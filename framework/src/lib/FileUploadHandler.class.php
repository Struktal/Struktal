<?php

class FileUploadHandler {
    private string $inputName = "file";
    private bool $multiple = false;
    private array $allowedMimeTypes = [];
    private ?int $maxSize = null;
    private array $files = [];
    private bool $uploadSuccessful = false;
    private array $uploadErrors = [];

    /**
     * Set the Input Name of the File Input
     * @param string $inputName
     * @return $this
     */
    public function setInputName(string $inputName): FileUploadHandler {
        $this->inputName = $inputName;
        return $this;
    }

    /**
     * Set whether multiple Files should be allowed
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple(bool $multiple): FileUploadHandler {
        $this->multiple = $multiple;
        return $this;
    }

    public function setAllowedMimeTypes(array $allowedMimeTypes): FileUploadHandler {
        $this->allowedMimeTypes = $allowedMimeTypes;
        return $this;
    }

    /**
     * Set the maximum allowed File Size in MiB for each uploaded File
     * @param int|null $maxSize
     * @return $this
     */
    public function setMaxSize(?int $maxSize): FileUploadHandler {
        if($maxSize !== null) {
            $this->maxSize = $maxSize * 1024 * 1024;
        } else {
            $this->maxSize = null;
        }

        return $this;
    }

    /**
     * Check whether a File is allowed to be uploaded
     * @param array $file
     * @return bool
     */
    private function checkFile(array $file): bool {
        if(!(is_uploaded_file($file["tmp_name"]) && $file["error"] === UPLOAD_ERR_OK)) {
            $this->uploadErrors[] = UploadErrors::UPLOAD_ERR_NOT_UPLOADED;
            return false;
        }

        if(!(in_array($file["type"], $this->allowedMimeTypes))) {
            $this->uploadErrors[] = UploadErrors::UPLOAD_ERR_TYPE;
            return false;
        }

        if($this->maxSize !== null && $file["size"] > $this->maxSize) {
            $this->uploadErrors[] = UploadErrors::UPLOAD_ERR_SIZE;
            return false;
        }

        return true;
    }

    /**
     * Handle the File Upload
     * @return $this
     */
    public function handleUpload(): FileUploadHandler {
        if(isset($_FILES[$this->inputName])) {
            $this->uploadSuccessful = true;

            $files = [];
            if($this->multiple) {
                if(is_array($_FILES[$this->inputName]["name"])) {
                    for($i = 0; $i < sizeof($_FILES[$this->inputName]["name"]); $i++) {
                        $file = [
                            "name" => $_FILES[$this->inputName]["name"][$i],
                            "type" => $_FILES[$this->inputName]["type"][$i],
                            "tmp_name" => $_FILES[$this->inputName]["tmp_name"][$i],
                            "error" => $_FILES[$this->inputName]["error"][$i],
                            "size" => $_FILES[$this->inputName]["size"][$i]
                        ];

                        if(!($this->checkFile($file))) {
                            $this->uploadSuccessful = false;
                        } else {
                            $files[] = $file;
                        }
                    }
                } else {
                    $file = $_FILES[$this->inputName];
                    if(!($this->checkFile($file))) {
                        $this->uploadSuccessful = false;
                    } else {
                        $files[] = $file;
                    }
                }
            } else {
                if(is_array($_FILES[$this->inputName]["name"])) {
                    $this->uploadErrors[] = UploadErrors::UPLOAD_ERR_NO_MULTIPLE;
                    $this->uploadSuccessful = false;
                } else {
                    $file = $_FILES[$this->inputName];
                    if(!($this->checkFile($file))) {
                        $this->uploadSuccessful = false;
                    } else {
                        $files[] = $file;
                    }
                }
            }

            $this->files = $files;
        }

        return $this;
    }

    /**
     * Get the uploaded Files
     * @return array
     */
    public function getFiles(): array {
        return $this->files;
    }

    /**
     * Check whether the Upload was successful
     * @return bool
     */
    public function successful(): bool {
        return $this->uploadSuccessful;
    }

    /**
     * Get the Upload Errors
     * @return array
     */
    public function getErrors(): array {
        return $this->uploadErrors;
    }
}
