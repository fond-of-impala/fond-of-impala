<?php

namespace FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business;

use FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\Reader\CompanyBusinessUnitReader;
use FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\Reader\CompanyBusinessUnitReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\NavisionCompanyBusinessUnit\NavisionCompanyBusinessUnitConfig getConfig()
 * @method \FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence\NavisionCompanyBusinessUnitRepositoryInterface getRepository()
 */
class NavisionCompanyBusinessUnitBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\Reader\CompanyBusinessUnitReaderInterface
     */
    public function createCompanyBusinessUnitReader(): CompanyBusinessUnitReaderInterface
    {
        return new CompanyBusinessUnitReader($this->getRepository());
    }
}
