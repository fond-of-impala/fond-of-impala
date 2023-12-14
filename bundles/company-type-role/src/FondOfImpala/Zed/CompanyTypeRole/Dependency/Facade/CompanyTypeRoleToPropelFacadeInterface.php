<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

interface CompanyTypeRoleToPropelFacadeInterface
{
    /**
     * @return string
     */
    public function getCurrentDatabaseEngine(): string;
}
