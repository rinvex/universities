# Rinvex University

**Rinvex University** is a simple and lightweight package for retrieving university details with flexibility. A whole bunch of data including name, native, iso codes, university family, university script, university cultures, and other attributes for the 180+ known universities worldwide at your fingertips.

[![Packagist](https://img.shields.io/packagist/v/rinvex/university.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/rinvex/university)
[![VersionEye Dependencies](https://img.shields.io/versioneye/d/php/rinvex:university.svg?label=Dependencies&style=flat-square)](https://www.versioneye.com/php/rinvex:university/)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/rinvex/university.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/rinvex/university/)
[![Code Climate](https://img.shields.io/codeclimate/github/rinvex/university.svg?label=CodeClimate&style=flat-square)](https://codeclimate.com/github/rinvex/university)
[![Travis](https://img.shields.io/travis/rinvex/university.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/rinvex/university)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/4505ee8a-52fc-4229-ae93-7e4f2523bda9.svg?label=SensioLabs&style=flat-square)](https://insight.sensiolabs.com/projects/4505ee8a-52fc-4229-ae93-7e4f2523bda9)
[![StyleCI](https://styleci.io/repos/77772990/shield)](https://styleci.io/repos/77772990)
[![License](https://img.shields.io/packagist/l/rinvex/university.svg?label=License&style=flat-square)](https://github.com/rinvex/university/blob/develop/LICENSE)


## Usage

Install via `composer require rinvex/university`, then use intuitively:
```php
// Get single university
$cairoUniversity = university('cairo-university');

// Get university name: Cairo University
echo $cairoUniversity->getName();

// Get university alternative name: null
echo $cairoUniversity->getAltName();

// Get university country: Egypt
echo $cairoUniversity->getCountry();

// Get university state: null
echo $cairoUniversity->getState();

// Get university address: {"street":"PO Box 12613, Nahdet Misr Street","city":"Giza","province":"Cairo","postal_code":null}
echo $cairoUniversity->getAddress();

// Get university street: PO Box 12613, Nahdet Misr Street
echo $cairoUniversity->getStreet();

// Get university city: Giza
echo $cairoUniversity->getCity();

// Get university province: Cairo
echo $cairoUniversity->getProvince();

// Get university postal code: null
echo $cairoUniversity->getPostalCode();

// Get university contact: {"telephone":"+20(2) 572-9584","website":"http:\/\/www.cu.edu.eg","email":"scc@cu.edu.eg","fax":"+20(2) 568-8884"}
echo $cairoUniversity->getContact();

// Get university telephone: +20(2) 572-9584
echo $cairoUniversity->getTelephone();

// Get university website: http://www.cu.edu.eg
echo $cairoUniversity->getWebsite();

// Get university email: scc@cu.edu.eg
echo $cairoUniversity->getEmail();

// Get university fax: +20(2) 568-8884
echo $cairoUniversity->getFax();

// Get university funding: Public
echo $cairoUniversity->getFunding();

// Get university languages: null
echo $cairoUniversity->getLanguages();

// Get university academic year: September to June (September-January; January-June)
echo $cairoUniversity->getAcademicYear();

// Get university accrediting agency: null
echo $cairoUniversity->getAccreditingAgency();


// Get all universities
$universities = universities();

// Get all universities in Egypt
$egyptUniversities = universities('egypt');
```

> **Notes:**
> - **Rinvex University** is framework-agnostic, so it's compatible with any PHP framework whatsoever without any dependencies at all, except for the PHP version itself **^7.0.0**. Awesome, huh? :smiley:
> - **Rinvex University** provides the global helpers for your convenience and for ease of use, but in fact it's just wrappers around the underlying `UniversityLoader` class, which you can utilize and use directly if you wish


## Features Explained

- University data are all stored here: `resources/names.json`.
- `name` - university english name
- `alt_name` - university alternative name
- `country` - university country
- `state` - university state
- `address` - university address details
    - street: university street
    - city: university city
    - province: university province
    - postal_code: university postal code
- `contact` - university contact details
    - telephone: university telephone
    - website: university website
    - email: university email
    - fax: university fax
- `funding` - university institution funding (public/private)
- `languages` - university teaching languages (array)
- `academic_year` - university academic year
- `accrediting_agency` - university accrediting agency


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Chat on Slack](http://chat.rinvex.com)
- [Help on Email](mailto:help@rinvex.com)
- [Follow on Twitter](https://twitter.com/rinvex)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)


## Security Vulnerabilities

We want to ensure that this package is secure for everyone. If you've discovered a security vulnerability in this package, we appreciate your help in disclosing it to us in a [responsible manner](https://en.wikipedia.org/wiki/Responsible_disclosure).

Publicly disclosing a vulnerability can put the entire community at risk. If you've discovered a security concern, please email us at [security@rinvex.com](mailto:security@rinvex.com). We'll work with you to make sure that we understand the scope of the issue, and that we fully address your concern. We consider correspondence sent to [security@rinvex.com](mailto:security@rinvex.com) our highest priority, and work to address any issues that arise as quickly as possible.

After a security vulnerability has been corrected, a security hotfix release will be deployed as soon as possible.


## About Rinvex

Rinvex is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Alexandria, Egypt since June 2016. We believe that our drive The Value, The Reach, and The Impact is what differentiates us and unleash the endless possibilities of our philosophy through the power of software. We like to call it Innovation At The Speed Of Life. That’s how we do our share of advancing humanity.


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2016-2017 Rinvex LLC, Some rights reserved.
