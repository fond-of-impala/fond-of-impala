<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence;

use FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConfig;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorPersistenceFactory getFactory()
 */
class ErpOrderCancellationMailConnectorRepository extends AbstractRepository implements ErpOrderCancellationMailConnectorRepositoryInterface
{
    /**
     * @param string $debtorNumber
     * @param array $roleNames
     *
     * @return array
     */
    public function getMailAddressesByDebtorNumberAndRoleNames(string $debtorNumber, array $roleNames): array
    {
        $emailAddresses = [];

        $customerQuery = $this->getCustomerQuery()
            ->useCompanyUserQuery()
                ->useCompanyQuery()
                    ->filterByDebtorNumber($debtorNumber)
                ->endUse()
                ->useSpyCompanyRoleToCompanyUserQuery()
                ->filterByFkCompanyRole_In($this->getCompanyRoleIdsByNameAndDebtorNumber($roleNames, $debtorNumber))->endUse()
            ->endUse()
            ->select(SpyCustomerTableMap::COL_EMAIL);

        $data = $customerQuery->find();

        if ($data->count() === 0) {
            return $emailAddresses;
        }

        return $data->getData();
    }

    /**
     * @param array $roleNames
     * @param string $debtorNumber
     *
     * @return array
     */
    public function getCompanyRoleIdsByNameAndDebtorNumber(array $roleNames, string $debtorNumber): array
    {
        $companyRoleQuery = $this->getCompanyRoleQuery()
                    ->useCompanyQuery()
                        ->filterByDebtorNumber($debtorNumber)
                    ->endUse()
                    ->filterByName_In($roleNames)
                    ->select(SpyCompanyRoleTableMap::COL_ID_COMPANY_ROLE);

        $data = $companyRoleQuery->find();

        if ($data->count() === 0) {
            return [];
        }

        return $data->getData();
    }

    /**
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomerByIdCustomer(int $idCustomer): ?CustomerTransfer
    {
        $customerEntity = $this->getCustomerQuery()->filterByIdCustomer($idCustomer)->findOne();

        if ($customerEntity === null) {
            return null;
        }

        return (new CustomerTransfer())->fromArray($customerEntity->toArray(), true);
    }

    /**
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    protected function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getFactory()->getCompanyQuery()->clear();
    }

    /**
     * @return \Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery
     */
    protected function getCompanyRoleQuery(): SpyCompanyRoleQuery
    {
        return $this->getFactory()->getCompanyRoleQuery()->clear();
    }

    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getFactory()->getCustomerQuery()->clear();
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConfig
     */
    protected function getConfig(): ErpOrderCancellationMailConnectorConfig
    {
        /** @var \FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConfig $config */
        $config = $this->getFactory()->getConfig();

        return $config;
    }
}
