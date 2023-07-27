<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Persistence\CompanyUsersBulkRestApiBusinessCentralConnectorPersistenceFactory getFactory()
 */
class CompanyUsersBulkRestApiBusinessCentralConnectorRepository extends AbstractRepository implements CompanyUsersBulkRestApiBusinessCentralConnectorRepositoryInterface
{
    /**
     * @param array $debtorNumbers
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkCompanyCollectionTransfer
     */
    public function findCompaniesByDebtorNumbers(array $debtorNumbers): CompanyUsersBulkCompanyCollectionTransfer
    {
        $collection = new CompanyUsersBulkCompanyCollectionTransfer();

        if (count($debtorNumbers) === 0) {
            return $collection;
        }
        $companyTransfers = $this->getCompanyMapByDebtorNumbers($debtorNumbers);

        return $collection->setCompanies(new ArrayObject($companyTransfers));
    }

    /**
     * @param array $debtorNumbers
     *
     * @return array<int, \Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer>
     */
    protected function getCompanyMapByDebtorNumbers(array $debtorNumbers): array
    {
        $result = $this->getFactory()->getCompanyQuery()
            ->filterByDebtorNumber_In($debtorNumbers)
            ->select([SpyCompanyTableMap::COL_ID_COMPANY, SpyCompanyTableMap::COL_DEBTOR_NUMBER])
            ->find();

        $collection = [];
        foreach ($result->getData() as $companyData) {
            $idCompany = $companyData[SpyCompanyTableMap::COL_ID_COMPANY];
            $debtorNumber = $companyData[SpyCompanyTableMap::COL_DEBTOR_NUMBER];
            $collection[$idCompany] = (new CompanyUsersBulkCompanyTransfer())
                ->setIdCompany($idCompany)
                ->setDebtorNumber($debtorNumber);
        }

        return $collection;
    }
}
