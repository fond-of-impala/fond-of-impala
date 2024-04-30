<?php

namespace FondOfImpala\Zed\CompanyUserSearchCompanyType\Persistence;

use Exception;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Orm\Zed\Company\Persistence\SpyCompany;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUser;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CompanyUserSearchCompanyType\Persistence\CompanyUserSearchCompanyTypePersistenceFactory getFactory()
 */
class CompanyUserSearchCompanyTypeRepository extends AbstractRepository implements CompanyUserSearchCompanyTypeRepositoryInterface
{
    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUser $spyCompanyUser
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function getCompanyByCompanyUserEntity(SpyCompanyUser $spyCompanyUser): CompanyTransfer
    {
        $company = $this->getSpyCompanyFromSpyCompanyUser($spyCompanyUser);

        if ($company === null) {
            throw new Exception(sprintf('Could not find company with id "%s"', $spyCompanyUser->getFkCompany()));
        }

        $companyTransfer = (new CompanyTransfer())->fromArray($company->toArray(), true);

        $foiCompanyType = $company->getFoiCompanyType();
        if ($foiCompanyType !== null) {
            $companyTypeTransfer = (new CompanyTypeTransfer())->fromArray($foiCompanyType->toArray(), true);
            $companyTransfer->setCompanyType($companyTypeTransfer);
        }

        return $companyTransfer;
    }

    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUser $spyCompanyUser
     *
     * @throws \Exception
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompany|null
     */
    protected function getSpyCompanyFromSpyCompanyUser(SpyCompanyUser $spyCompanyUser): ?SpyCompany
    {
        if ($spyCompanyUser->getFkCompany() === null) { // @phpstan-ignore-line
            throw new Exception('fkCompany is required!');
        }

        $company = $spyCompanyUser->getCompany();

        if ($company === null) { // @phpstan-ignore-line
            $company = $this->getFactory()->getCompanyQuery()->findOneByIdCompany($spyCompanyUser->getFkCompany());
        }

        return $company;
    }
}
