<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business;

use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilter;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Reader\CompanyReader;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Reader\CompanyReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Persistence\BusinessCentralProductListsBulkRestApiRepositoryInterface getRepository()
 */
class BusinessCentralProductListsBulkRestApiBusinessFactory extends AbstractBusinessFactory
{
 /**
  * @return \FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface
  */
    public function createRestProductListsBulkRequestExpander(): RestProductListsBulkRequestExpanderInterface
    {
        return new RestProductListsBulkRequestExpander(
            $this->createGroupedIdentifierFilter(),
            $this->createCompanyReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface
     */
    protected function createGroupedIdentifierFilter(): GroupedIdentifierFilterInterface
    {
        return new GroupedIdentifierFilter();
    }

    /**
     * @return \FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Reader\CompanyReaderInterface
     */
    protected function createCompanyReader(): CompanyReaderInterface
    {
        return new CompanyReader($this->getRepository());
    }
}
