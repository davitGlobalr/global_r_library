# GlobalrApiServiceV2 library
 

GlobalrApiServiceV2 is an PHP library meticulously designed to facilitate seamless integration with the Globalr system. With it  of classe, developers gain effortless programmatic access to a diverse range of endpoints and functionalities. This library empowers developers to efficiently manage domains, user accounts, and various other aspects of the Globalr system, enabling streamlined automation and enhanced control. Crafted with pure PHP, GlobalrApiServiceV2 offers a robust and versatile solution for developers seeking to interact with the Globalr system programmatically, simplifying the development process and unlocking new possibilities for application integration.
 
### Requirements

PHPPresentation requires the following:

- PHP 7.2+
### Installation

#### Manual download method

```php
require_once 'path/to/src/GlobalrApiServiceV2.php';
$globalrService = new GlobalrApiServiceV2();
```

## Getting started

The following is a basic usage example of the GlobalrApiServiceV2 library.

```php
// with your own install
require_once 'path/to/src/GlobalrApiServiceV2.php';
$globalrService = new GlobalrApiServiceV2();

// Get user/reseller detail information
$response = $globalrService->resellerInfo();

// Get Domain Infomation
$response = $globalrService->getDomainInfomation('example.com');

// Domain registration
$contact = [
        'name' => "Jhone",
        'surname' => "Smith",
        'email' => "smith@gmail.com",
        'phone' => "+37455555555",
        'country' => "US",
         'city' => "New York",
        'address' => "Example Street",
        'zip' => "001110"
    ];
$domainModel = [
        'name' => 'test-for-globalr.am',
        'periods' => 1,
        'contacts' => [
            'owner' => $contact,
            'admin' => $contact,
            'billing' => $contact,
            'technical' => $contact,
        ],
        'ns' => [
            ['name'=>'ns1.globalr.com'],
            ['name'=>'ns2.globalr.com'],

        ],
        "_am-privacy"=>1
    ];
    
$response = $globalrService->registerDomain($domainModel);

// Update domain

$contact = [
        'name' => "Jhone",
        'surname' => "Smith",
        'email' => "new-email@gmail.com",
        'phone' => "+37455555555",
        'country' => "US",
         'city' => "New York",
        'address' => "Example Street",
        'zip' => "001110"
    ];
$domainModel = [
        'name' => 'update-for-globalr.am',
        'contacts' => [
            'admin' => $contact,
            'owner' => $contact,
            'technical' => $contact,
            'billing' => $contact,
        ],
        "_am-private"=> 1
    ];

$response = $globalrService->modifyDomain($domainModel);

// Domain renew (first renew 1 year, second renew 3 years)
$renew = [
    'domains' =>
        ['renew-domain-1.am' => 1],
        ['renew-domain-2.am' => 3],
];
$response = $globalrService->renewDomain($renew);

 ```
