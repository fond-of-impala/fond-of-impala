# Company Users Bulk Rest Api Debtor Connector
[![CI](https://github.com/fond-of-impala/company-users-bulk-rest-api-business-central-connector/actions/workflows/main.yml/badge.svg)](https://github.com/fond-of-impala/company-users-bulk-rest-api-business-central-connector/actions/workflows/main.yml)
[![license](https://img.shields.io/github/license/fond-of-impala/company-users-bulk-rest-api-business-central-connector.svg)](https://packagist.org/packages/fond-of-impala/company-users-bulk-rest-api-business-central-connector)

Allows to add and delete company users by debtor number

## Installation
```
composer require fond-of-impala/company-users-bulk-rest-api-business-central-connector
```


## Configuration
Register plugin
```
<?php

namespace Pyz\Zed\CompanyUsersBulkRestApi;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiDependencyProvider as FooCompanyUsersBulkRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Communication\Plugin\CompanyUsersBulkRestApi\CompanyDebtorNumberResolverPreDataExpanderPlugin;

class CompanyUsersBulkRestApiDependencyProvider extends FooCompanyUsersBulkRestApiDependencyProvider
{
    /**
     * @return array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkDataExpanderPluginInterface>
     */
    protected function getDataExpanderPlugins(): array
    {
        return [
        ...
            new CompanyDebtorNumberResolverPreDataExpanderPlugin(),
        ];
    }
}
```



## Usage
```
POST {{glue_uri}}/company-users-bulk
Content-Type: application/vnd.api+json;version=1.1
Authorization: {{tokenType}} {{accessToken}}
Accept: application/vnd.api+json

{
    "data": {
        "type": "company-users-bulk",
        "attributes": {
          "assign": [
              {
                "customer":
                {
                    "customerReference": "JD--371",
                    "email": "john.doe@johndoe.de"
                },
                "company":
                {
                    "companyId": "",
                    "debtorNumber": "D123221"
                },
                  "role": "superadministration"
              },
              {
                "customer":
                {
                    "customerReference": "",
                    "email": "jane.doe@johndoe.de"
                },
                "company":
                {
                    "companyId": "",
                    "debtorNumber": "D123222"
                },
                  "role": "administration"
              }
          ],
            "unassign": [
              {
                "customer":
                {
                    "customerReference": "JD--373",
                    "email": ""
                },
                "company":
                {
                    "companyId": "",
                    "debtorNumber": "D123223"
                },
                  "role": "administration"
              }
            ]
        }
    }
}
```

