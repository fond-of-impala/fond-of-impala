<?php

namespace FondOfImpala\Client\NavisionCompany;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\NavisionCompany\NavisionCompanyFactory getFactory()
 */
class NavisionCompanyClient extends AbstractClient implements NavisionCompanyClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * {@internal will work if external reference field is provided.}
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function findCompanyByExternalReference(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        return $this->getFactory()->createZedNavisionCompanyStub()
            ->findCompanyByExternalReference($companyTransfer);
    }
}
