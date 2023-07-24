<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Builder;

use Codeception\Test\Unit;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;

class CompanyRoleCriteriaFilterBuilderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Builder\CompanyRoleCriteriaFilterBuilder
     */
    protected $companyRoleCriteriaFilterBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleCriteriaFilterBuilder = new CompanyRoleCriteriaFilterBuilder();
    }

    /**
     * @return void
     */
    public function testBuildByPageAndMaxPerPage(): void
    {
        $page = 1;
        $maxPerPage = 10;

        $companyRoleCriteriaFilterTransfer = $this->companyRoleCriteriaFilterBuilder->buildByPageAndMaxPerPage(
            $page,
            $maxPerPage,
        );

        static::assertEquals(
            $page,
            $companyRoleCriteriaFilterTransfer->getPagination()->getPage(),
        );

        static::assertEquals(
            $maxPerPage,
            $companyRoleCriteriaFilterTransfer->getPagination()->getMaxPerPage(),
        );

        static::assertEquals(
            'asc',
            $companyRoleCriteriaFilterTransfer->getFilter()->getOrderDirection(),
        );

        static::assertEquals(
            SpyCompanyRoleTableMap::COL_ID_COMPANY_ROLE,
            $companyRoleCriteriaFilterTransfer->getFilter()->getOrderBy(),
        );
    }
}
