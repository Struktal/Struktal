<?php

class CSVReader {
    private $file = null;
    private ?int $maxLength = null;
    private string $delimiter = ",";
    private array $data = array();

    /**
     * Set the CSV File that should be read
     * @param resource $file
     * @return $this
     */
    public function setFile($file): CSVReader {
        $this->file = $file;
        return $this;
    }

    /**
     * Set the maximum Length of a Line
     * @param int|null $maxLength
     * @return $this
     */
    public function setMaxLineLength(?int $maxLength): CSVReader {
        $this->maxLength = $maxLength;
        return $this;
    }

    /**
     * Set the Delimiter that should be used
     * @param string $delimiter
     * @return $this
     */
    public function setDelimiter(string $delimiter): CSVReader {
        $this->delimiter = substr($delimiter, 0, 1);
        return $this;
    }

    /**
     * Detect the Delimiter from the CSV File
     * @return $this
     */
    public function detectDelimiter(): CSVReader {
        if($this->file !== null) {
            $delimiters = array("," => 0, ";" => 0, "\t" => 0, "|" => 0);

            $handle = fopen($this->file, "r");
            $firstLine = fgets($handle);
            fclose($handle);
            foreach($delimiters as $delimiter => &$count) {
                $count = sizeof(str_getcsv($firstLine, $delimiter));
            }

            $this->delimiter = array_search(max($delimiters), $delimiters);
        }

        return $this;
    }

    /**
     * Read all Data from the CSV File
     * @return $this
     */
    public function read(): CSVReader {
        if($this->file !== null) {
            $csvHandle = fopen($this->file, "r");
            while(($data = fgetcsv($csvHandle, $this->maxLength, $this->delimiter)) !== false) {
                $this->data[] = $data;
            }
        }

        return $this;
    }

    /**
     * Get the Data from the CSV File
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }
}
