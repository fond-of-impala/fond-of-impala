<?php

namespace FondOfImpala\Zed\NavisionCompanyUnitAddress\Business;

use FondOfImpala\Zed\NavisionCompanyUnitAddress\Business\Reader\CompanyUnitAddressReader;
use FondOfImpala\Zed\NavisionCompanyUnitAddress\Business\Reader\CompanyUnitAddressReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\NavisionCompanyUnitAddress\NavisionCompanyUnitAddressConfig getConfig()
 * @method \FondOfImpala\Zed\NavisionCompanyUnitAddress\Persistence\NavisionCompanyUnitAddressRepositoryInterface getRepository()
 */
class NavisionCompanyUnitAddressBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\NavisionCompanyUnitAddress\Business\Reader\CompanyUnitAddressReaderInterface
     */
    public function createCompanyUnitAddressReader(): CompanyUnitAddressReaderInterface
    {
        return new CompanyUnitAddressReader($this->getRepository());
    }
}
