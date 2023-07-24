<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Builder;

use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;

interface CompanyRoleCriteriaFilterBuilderInterface
{
    /**
     * @param int $page
     * @param int $maxPerPage
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer
     */
    public function buildByPageAndMaxPerPage(int $page, int $maxPerPage): CompanyRoleCriteriaFilterTransfer;
}
