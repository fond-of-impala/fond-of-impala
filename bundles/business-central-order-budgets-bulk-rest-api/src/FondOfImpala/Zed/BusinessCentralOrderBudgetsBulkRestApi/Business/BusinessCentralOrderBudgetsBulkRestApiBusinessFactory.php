<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business;

use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpander;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpanderInterface;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Filter\DebtorNumbersFilter;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Filter\DebtorNumbersFilterInterface;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReader;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Persistence\BusinessCentralOrderBudgetsBulkRestApiRepositoryInterface getRepository()
 */
class BusinessCentralOrderBudgetsBulkRestApiBusinessFactory extends AbstractBusinessFactory
{
 /**
  * @return \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpanderInterface
  */
    public function createRestOrderBudgetsBulkRequestExpander(): RestOrderBudgetsBulkRequestExpanderInterface
    {
        return new RestOrderBudgetsBulkRequestExpander(
            $this->createDebtorNumbersFilter(),
            $this->createCompanyReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Filter\DebtorNumbersFilterInterface
     */
    protected function createDebtorNumbersFilter(): DebtorNumbersFilterInterface
    {
        return new DebtorNumbersFilter();
    }

    /**
     * @return \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface
     */
    protected function createCompanyReader(): OrderBudgetReaderInterface
    {
        return new OrderBudgetReader($this->getRepository());
    }
}
