# CompanyTypeConverter Module
[![CI](https://github.com/fond-of-impala/company-type-converter/actions/workflows/main.yml/badge.svg)](https://github.com/fond-of-impala/company-type-converter/actions/workflows/main.yml)
[![license](https://img.shields.io/github/license/fond-of-impala/company-type-converter.svg)](https://packagist.org/packages/fond-of-impala/company-type-converter)

## Installation

```
composer require fond-of-impala/company-type-converter
```

## Configuration

Register plugins in `CompanyDependencyProvider`
```
CompanyTypeConverterCompanyPreSavePlugin
CompanyTypeConverterCompanyPostSavePlugin
```

The `CompanyTypeConverterCompanyPreSavePlugin` now supports a blacklist functionality. By default, all converts are whitelisted. After setting up the config

```
$config[CompanyTypeConverterConstants::COMPANY_TYPE_NON_CONVERTIBLE_ROLE_TYPE_KEYS] = [
    'manufacturer' => ['retailer', 'distributor'],
    'distributor' => ['manufacturer'],
    'retailer' => ['manufacturer']
];
```
for example the manufacturer can not be converted to a retailer or distributor. The distributor can not be converted as a manufacturer, but he could be converted to a retailer. Same goes for the retailer. He can not converted to a manufacturer but can converted to a distributor.
