<?php

namespace FondOfImpala\Zed\CompanyUsersRestApiPriceListConnector\Communication\Plugin\CompanyUsersRestApi;

use FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\QueryExpander\CompanyUserQueryExpanderPluginInterface;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class PriceListCompanyUserQueryExpanderPlugin extends AbstractPlugin implements CompanyUserQueryExpanderPluginInterface
{
    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery $companyUserQuery
     *
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function expandCompanyUserQuery(SpyCompanyUserQuery $companyUserQuery): SpyCompanyUserQuery
    {
        $companyUserQuery
            ->useCompanyQuery()
                ->usePriceListQuery()
                ->endUse()
            ->endUse();

        return $companyUserQuery;
    }
}
