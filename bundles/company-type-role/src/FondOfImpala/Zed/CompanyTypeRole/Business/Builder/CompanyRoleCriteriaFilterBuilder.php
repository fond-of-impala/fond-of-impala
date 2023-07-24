<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Builder;

use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\FilterTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;

class CompanyRoleCriteriaFilterBuilder implements CompanyRoleCriteriaFilterBuilderInterface
{
    /**
     * @param int $page
     * @param int $maxPerPage
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer
     */
    public function buildByPageAndMaxPerPage(int $page, int $maxPerPage): CompanyRoleCriteriaFilterTransfer
    {
        $filterTransfer = (new FilterTransfer())
            ->setOrderBy(SpyCompanyRoleTableMap::COL_ID_COMPANY_ROLE)
            ->setOrderDirection('asc');

        $paginationTransfer = (new PaginationTransfer())
            ->setPage($page)
            ->setMaxPerPage($maxPerPage);

        return (new CompanyRoleCriteriaFilterTransfer())
            ->setFilter($filterTransfer)
            ->setPagination($paginationTransfer);
    }
}
