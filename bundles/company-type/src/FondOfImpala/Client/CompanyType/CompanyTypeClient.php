<?php

namespace FondOfImpala\Client\CompanyType;

use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\CompanyType\CompanyTypeFactory getFactory()
 */
class CompanyTypeClient extends AbstractClient implements CompanyTypeClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    public function findCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeResponseTransfer
    {
        return $this->getFactory()->createZedCompanyTypeStub()->findCompanyTypeById($companyTypeTransfer);
    }
}
