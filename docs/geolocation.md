# Documentation
## Geolocation
> <b>Legal Note:</b> This library uses the [Nominatim](https://nominatim.org/) API. Please read the [Terms of Use](https://operations.osmfoundation.org/policies/nominatim/) before using it and comply with them.

The geocoding library allows you to get the coordinates of an address or the address of coordinates. To do that, use
```php
// Get coordinates of an address
$geolocation = new Geolocation();
$geolocation->setStreet("Street");
$geolocation->setHouseNumber("House number");
$geolocation->setCity("City");
$geolocation->setZipCode("ZIP code");
$geolocation->setCountry("Country");
$coordinates = $geolocation->getCoordinates();
$lat = $coordinates["latitude"];
$lng = $coordinates["longitude"];

// Get address of coordinates
$geolocation = new Geolocation();
$geolocation->setCoordinates(12.345678, 12.345678);
$address = $geolocation->getAddress();
$street = $address["street"];
$houseNumber = $address["houseNumber"];
$city = $address["city"];
$zipCode = $address["zipCode"];
$country = $address["country"];
$formattedAddress = $geolocation->getFormattedAddress();
```