<?php

namespace FondOfImpala\Zed\NavisionCompanyUser\Business;

use FondOfImpala\Zed\NavisionCompanyUser\Business\Reader\CompanyUserReader;
use FondOfImpala\Zed\NavisionCompanyUser\Business\Reader\CompanyUserReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\NavisionCompanyUser\Persistence\NavisionCompanyUserRepositoryInterface getRepository()
 */
class NavisionCompanyUserBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\NavisionCompanyUser\Business\Reader\CompanyUserReaderInterface
     */
    public function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader($this->getRepository());
    }
}
