<?php

namespace FondOfImpala\Zed\CompanyType\Persistence;

use Generated\Shared\Transfer\CompanyTypeTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypePersistenceFactory getFactory()
 */
class CompanyTypeEntityManager extends AbstractEntityManager implements CompanyTypeEntityManagerInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function persist(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer
    {
        $foiCompanyType = $this->getFactory()
            ->createCompanyTypeQuery()
            ->filterByIdCompanyType($companyTypeTransfer->getIdCompanyType())
            ->findOneOrCreate();

        $foiCompanyType = $this->getFactory()
            ->createCompanyTypeMapper()
            ->mapTransferToEntity($companyTypeTransfer, $foiCompanyType);

        $foiCompanyType->save();

        $companyTypeTransfer->setIdCompanyType($foiCompanyType->getIdCompanyType());

        return $companyTypeTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @param int $idCompanyType
     *
     * @return void
     */
    public function deleteById(int $idCompanyType): void
    {
        $this->getFactory()
            ->createCompanyTypeQuery()
            ->filterByIdCompanyType($idCompanyType)
            ->delete();
    }
}
