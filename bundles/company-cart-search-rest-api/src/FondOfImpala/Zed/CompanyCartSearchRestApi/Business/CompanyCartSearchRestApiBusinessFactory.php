<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business;

use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Expander\QueryJoinCollectionExpander;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Expander\QueryJoinCollectionExpanderInterface;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\CompanyUuidFilter;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\CompanyUuidFilterInterface;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\IdCustomerFilter;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\IdCustomerFilterInterface;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader\CompanyReader;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader\CompanyReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepositoryInterface getRepository()
 */
class CompanyCartSearchRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Expander\QueryJoinCollectionExpanderInterface
     */
    public function createQueryJoinCollectionExpander(): QueryJoinCollectionExpanderInterface
    {
        return new QueryJoinCollectionExpander(
            $this->createCompanyReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader\CompanyReaderInterface
     */
    protected function createCompanyReader(): CompanyReaderInterface
    {
        return new CompanyReader(
            $this->createIdCustomerFilter(),
            $this->createCompanyUuidFilter(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\IdCustomerFilterInterface
     */
    protected function createIdCustomerFilter(): IdCustomerFilterInterface
    {
        return new IdCustomerFilter();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\CompanyUuidFilterInterface
     */
    protected function createCompanyUuidFilter(): CompanyUuidFilterInterface
    {
        return new CompanyUuidFilter();
    }
}
