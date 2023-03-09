<?php

class Geolocation {
    private static string $API_URL = "https://nominatim.openstreetmap.org/";
    private array $address;
    private array $coordinates;
    
    public function __construct() {
        $this->coordinates = array(
            "latitude" => null,
            "longitude" => null
        );
        $this->address = array(
            "street" => null,
            "houseNumber" => null,
            "city" => null,
            "zipCode" => null,
            "country" => null
        );
    }

    public function setCoordinates(float $latitude, float $longitude): Geolocation {
        if(($latitude >= -90 || $latitude <= 90) && ($longitude >= -180 || $longitude <= 180)) {
            $this->coordinates["latitude"] = $latitude;
            $this->coordinates["longitude"] = $longitude;
        } else {
            $this->coordinates["latitude"] = null;
            $this->coordinates["longitude"] = null;
        }

        return $this;
    }

    public function setStreet(string $street): Geolocation {
        $this->address["street"] = $street;
        return $this;
    }

    public function setHouseNumber(string $houseNumber): Geolocation {
        $this->address["houseNumber"] = $houseNumber;
        return $this;
    }

    public function setCity(string $city): Geolocation {
        $this->address["city"] = $city;
        return $this;
    }

    public function setZipCode(string $zipCode): Geolocation {
        $this->address["zipCode"] = $zipCode;
        return $this;
    }

    public function setCountry(string $country): Geolocation {
        $this->address["country"] = $country;
        return $this;
    }

    public function setCountryCode(string $countryCode): Geolocation {
        $this->address["countryCode"] = $countryCode;
        return $this;
    }

    public function getCoordinates(): array {
        return $this->coordinates;
    }

    public function getAddress(): array {
        return $this->address;
    }

    public function getFormattedAddress(): array {
        $addressInline = "";
        $addressLineBreaks = "";

        if(isset($this->address["street"])) {
            $addressInline .= $this->address["street"];
            $addressLineBreaks .= $this->address["street"];

            if(isset($this->address["houseNumber"])) {
                $addressInline .= " " . $this->address["houseNumber"];
                $addressLineBreaks .= " " . $this->address["houseNumber"];
            }
        }

        if(isset($this->address["zipCode"]) || isset($this->address["city"])) {
            $addressInline .= ", ";
            $addressLineBreaks .= PHP_EOL;
        }

        if(isset($this->address["zipCode"])) {
            $addressInline .= $this->address["zipCode"];
            $addressLineBreaks .= $this->address["zipCode"];

            if(isset($this->address["city"])) {
                $addressInline .= " ";
                $addressLineBreaks .= " ";
            }
        }

        if(isset($this->address["city"])) {
            $addressInline .= $this->address["city"];
            $addressLineBreaks .= $this->address["city"];
        }

        if(isset($this->address["country"]) || isset($this->address["countryCode"])) {
            $addressInline .= ", ";
            $addressLineBreaks .= PHP_EOL;
        }

        if(isset($this->address["countryCode"])) {
            if(isset($this->address["country"])) {
                $addressInline .= $this->address["country"] . " (" . $this->address["countryCode"] . ")";
                $addressLineBreaks .= $this->address["country"] . "(" . $this->address["countryCode"] . ")";
            } else {
                $addressInline .= $this->address["countryCode"];
                $addressLineBreaks .= $this->address["countryCode"];
            }
        } else {
            if(isset($this->address["country"])) {
                $addressInline .= $this->address["country"];
                $addressLineBreaks .= $this->address["country"];
            }
        }

        return array(
            "inline" => $addressInline,
            "lineBreaks" => $addressLineBreaks
        );
    }

    public function toAddress(): Geolocation {
        $url = self::$API_URL . "reverse?format=json";
        $url .= "&lat=" . $this->coordinates["latitude"];
        $url .= "&lon=" . $this->coordinates["longitude"];
        $url = str_replace(" ", "%20", $url);

        $curl = new Curl();
        $curl->setUrl($url);
        $curl->setMethod(Curl::$METHOD_GET);
        $curl->addHeader("Content-Type: application/json");
        $curl->addHeader("User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/109.0");
        $response = json_decode($curl->execute(), true);

        foreach(array("road", "street") as $key) {
            if(isset($response["address"][$key])) {
                $this->setStreet($response["address"][$key]);
                break;
            }
        }

        foreach(array("house_number", "housenumber") as $key) {
            if(isset($response["address"][$key])) {
                $this->setHouseNumber($response["address"][$key]);
                break;
            }
        }

        foreach(array("city", "town", "village", "quarter") as $key) {
            if(isset($response["address"][$key])) {
                $this->setCity($response["address"][$key]);
                break;
            }
        }

        foreach(array("postcode", "postalcode") as $key) {
            if(isset($response["address"][$key])) {
                $this->setZipCode($response["address"][$key]);
                break;
            }
        }

        foreach(array("country") as $key) {
            if(isset($response["address"][$key])) {
                $this->setCountry($response["address"][$key]);
                break;
            }
        }

        foreach(array("country_code", "countrycode") as $key) {
            if(isset($response["address"][$key])) {
                $this->setCountryCode(strtoupper($response["address"][$key]));
                break;
            }
        }

        return $this;
    }

    public function toCoordinates(): Geolocation {
        $url = self::$API_URL . "search?format=json";
        $url .= "&street=" . $this->address["street"] . " " . $this->address["houseNumber"];
        $url .= "&city=" . $this->address["city"];
        $url .= "&postalcode=" . $this->address["zipCode"];
        $url .= "&country=" . $this->address["country"];
        $url = str_replace(" ", "%20", $url);

        $curl = new Curl();
        $curl->setUrl($url);
        $curl->setMethod(Curl::$METHOD_GET);
        $curl->addHeader("Content-Type: application/json");
        $curl->addHeader("User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/109.0");
        $response = json_decode($curl->execute(), true);

        $this->setCoordinates($response[0]["lat"], $response[0]["lon"]);

        return $this;
    }
}