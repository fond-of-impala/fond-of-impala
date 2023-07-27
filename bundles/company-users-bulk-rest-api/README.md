# Company Users Bulk Rest Api
[![CI](https://github.com/fond-of-impala/company-users-bulk-rest-api/actions/workflows/main.yml/badge.svg)](https://github.com/fond-of-impala/company-users-bulk-rest-api/actions/workflows/main.yml)
[![license](https://img.shields.io/github/license/fond-of-impala/company-users-bulk-rest-api.svg)](https://packagist.org/packages/fond-of-impala/company-users-bulk-rest-api)

Adds functionality to bulk add company user and assign roles from glue front end.

## Installation
```
composer require fond-of-impala/company-users-bulk-rest-api
```


## Configuration
Register plugins and add assign the `CanBulkCreateCompanyUsersPermissionPlugin` permission to user.
```
<?php

namespace Pyz\Glue\GlueApplication;

use FondOfImpala\Glue\CompanyUsersBulkRestApi\Plugin\GlueApplicationExtension\CompanyUsersBulkResourceRoutePlugin;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class GlueApplicationDependencyProvider extends SprykerGlueApplicationDependencyProvider
{
    /**
     * {@inheritDoc}
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface>
     */
    protected function getResourceRoutePlugins(): array
    {
        return [
            ...
            new CompanyUsersBulkResourceRoutePlugin(),
        ];
    }
}

```

```
<?php

namespace Pyz\Zed\Event;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Subscriber\CompanyUsersBulkRestApiEventSubscriber;

class EventDependencyProvider extends SprykerEventDependencyProvider
{
    /**
     * @return \Spryker\Zed\Event\Dependency\EventSubscriberCollectionInterface
     */
    public function getEventSubscriberCollection()
    {
        ...
        $eventSubscriberCollection->add(new CompanyUsersBulkRestApiEventSubscriber());

        return $eventSubscriberCollection;
    }
}
```

```
<?php

namespace Pyz\Zed\CompanyUsersBulkRestApi;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\CompanyResolverPreDataExpanderPlugin;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\CustomerByEmailResolverPreDataExpanderPlugin;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\CustomerByReferenceResolverPreDataExpanderPlugin;
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
            new CompanyResolverPreDataExpanderPlugin(),
            new CustomerByReferenceResolverPreDataExpanderPlugin(),
            new CustomerByEmailResolverPreDataExpanderPlugin(),
        ];
    }
}
```
```
<?php

namespace Pyz\Zed\Permission;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\PermissionExtension\CanBulkCreateCompanyUsersPermissionPlugin;
use Spryker\Zed\Permission\PermissionDependencyProvider as SprykerPermissionDependencyProvider;

class PermissionDependencyProvider extends SprykerPermissionDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\PermissionExtension\Dependency\Plugin\PermissionStoragePluginInterface>
     */
    protected function getPermissionStoragePlugins(): array
    {
        return [
            new PermissionStoragePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface>
     */
    protected function getPermissionPlugins(): array
    {
        return [
            ...
            new CanBulkCreateCompanyUsersPermissionPlugin(),
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
                    "email": ""
                },
                "company":
                {
                    "companyId": "UUID1"
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
                    "companyId": "UUID2"
                },
                  "role": "administration"
              }
          ],
            "unassign": [
              {
                "customer":
                {
                    "customerReference": "JD--373",
                    "email": "pete.doe@johndoe.de"
                },
                "company":
                {
                    "companyId": "UUID3"
                },
                  "role": "administration"
              }
            ]
        }
    }
}
```

