<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business;

use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilter;
use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Reader\CustomerReader;
use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Reader\CustomerReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Persistence\CompanyTypeProductListsBulkRestApiRepositoryInterface getRepository()
 */
class CompanyTypeProductListsBulkRestApiBusinessFactory extends AbstractBusinessFactory
{
 /**
  * @return \FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface
  */
    public function createRestProductListsBulkRequestExpander(): RestProductListsBulkRequestExpanderInterface
    {
        return new RestProductListsBulkRequestExpander(
            $this->createGroupedIdentifierFilter(),
            $this->createCustomerReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface
     */
    protected function createGroupedIdentifierFilter(): GroupedIdentifierFilterInterface
    {
        return new GroupedIdentifierFilter();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Reader\CustomerReaderInterface
     */
    protected function createCustomerReader(): CustomerReaderInterface
    {
        return new CustomerReader($this->getRepository());
    }
}
