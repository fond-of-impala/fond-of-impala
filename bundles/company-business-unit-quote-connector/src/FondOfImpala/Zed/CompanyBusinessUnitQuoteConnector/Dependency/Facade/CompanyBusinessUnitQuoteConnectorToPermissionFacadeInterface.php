<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade;

interface CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface
{
    /**
     * @param string $permissionKey
     * @param string|int $identifier
     * @param array|string|int|null $context
     *
     * @return bool
     */
    public function can($permissionKey, $identifier, $context = null): bool;
}
