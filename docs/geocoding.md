# Documentation
## Geocoding
> <b>Legal Note:</b> This library uses the [Nominatim](https://nominatim.org/) API. Please read the [Terms of Use](https://operations.osmfoundation.org/policies/nominatim/) before using it and comply with them.

The geocoding library allows you to get the coordinates of an address or the address of coordinates. To do that, use
```php
// Get coordinates of an address
$geocoding = new Geocoding();
$geocoding->setStreet("Street");
$geocoding->setHouseNumber("House number");
$geocoding->setCity("City");
$geocoding->setZipCode("ZIP code");
$geocoding->setCountry("Country");
$coordinates = $geocoding->getCoordinates();
$lat = $coordinates["latitude"];
$lng = $coordinates["longitude"];

// Get address of coordinates
$geocoding = new Geocoding();
$geocoding->setCoordinates(12.345678, 12.345678);
$address = $geocoding->getAddress();
$street = $address["street"];
$houseNumber = $address["houseNumber"];
$city = $address["city"];
$zipCode = $address["zipCode"];
$country = $address["country"];
$formattedAddress = $geocoding->getFormattedAddress();
```