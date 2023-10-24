<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Expander;

use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;

class CompanyUserQueryExpander implements CompanyUserQueryExpanderInterface
{
    /**
     * @var \FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\QueryExpander\CompanyUserQueryExpanderPluginInterface[]|array
     */
    protected array $expanderPlugins;

    /**
     * @param array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\QueryExpander\CompanyUserQueryExpanderPluginInterface> $expanderPlugins
     */
    public function __construct(array $expanderPlugins)
    {
        $this->expanderPlugins = $expanderPlugins;
    }

    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery $companyUserQuery
     *
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function expand(SpyCompanyUserQuery $companyUserQuery): SpyCompanyUserQuery
    {
        foreach ($this->expanderPlugins as $expanderPlugin) {
            $companyUserQuery = $expanderPlugin->expandCompanyUserQuery($companyUserQuery);
        }

        return $companyUserQuery;
    }
}
