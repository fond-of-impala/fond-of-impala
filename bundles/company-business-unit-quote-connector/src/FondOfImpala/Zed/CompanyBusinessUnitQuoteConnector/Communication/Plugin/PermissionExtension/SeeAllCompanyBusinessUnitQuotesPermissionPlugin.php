<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Communication\Plugin\PermissionExtension;

use Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface;

class SeeAllCompanyBusinessUnitQuotesPermissionPlugin implements PermissionPluginInterface
{
    /**
     * @var string
     */
    public const KEY = 'SeeAllCompanyBusinessUnitQuotesPermissionPlugin';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getKey(): string
    {
        return static::KEY;
    }
}
