<?php

namespace FondOfImpala\Zed\NavisionCompany\Business;

use FondOfImpala\Zed\NavisionCompany\Business\Reader\CompanyReader;
use FondOfImpala\Zed\NavisionCompany\Business\Reader\CompanyReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\NavisionCompany\NavisionCompanyConfig getConfig()
 * @method \FondOfImpala\Zed\NavisionCompany\Persistence\NavisionCompanyRepositoryInterface getRepository()
 */
class NavisionCompanyBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\NavisionCompany\Business\Reader\CompanyReaderInterface
     */
    public function createCompanyReader(): CompanyReaderInterface
    {
        return new CompanyReader($this->getRepository());
    }
}
