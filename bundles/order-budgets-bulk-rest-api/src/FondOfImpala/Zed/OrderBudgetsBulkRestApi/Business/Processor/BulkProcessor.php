<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Processor;

use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Checker\RestOrderBudgetsBulkRequestAssignmentCheckerInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\OrderBudgetsBulkRestApiEvents;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;
use Throwable;

class BulkProcessor implements BulkProcessorInterface
{
    protected OrderBudgetsBulkRestApiToEventFacadeInterface $eventFacade;

    protected array $restOrderBudgetsBulkRequestExpanderPlugins;

    /**
     * @param \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToEventFacadeInterface $eventFacade
     * @param array<\FondOfImpala\Zed\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestExpanderPluginInterface> $restOrderBudgetsBulkRequestExpanderPlugins
     */
    public function __construct(
        OrderBudgetsBulkRestApiToEventFacadeInterface $eventFacade,
        array $restOrderBudgetsBulkRequestExpanderPlugins
    ) {
        $this->eventFacade = $eventFacade;
        $this->restOrderBudgetsBulkRequestExpanderPlugins = $restOrderBudgetsBulkRequestExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer
     */
    public function process(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkResponseTransfer {
        try {
            return $this->executeProcess($restOrderBudgetsBulkRequestTransfer);
        } catch (Throwable) {
            return (new RestOrderBudgetsBulkResponseTransfer())
                ->setIsSuccessful(false);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer
     */
    protected function executeProcess(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkResponseTransfer {
        $currentCount = 0;
        $actualCount = $restOrderBudgetsBulkRequestTransfer->getOrderBudgets()
            ->count();

        foreach ($this->restOrderBudgetsBulkRequestExpanderPlugins as $plugin) {
            $restOrderBudgetsBulkRequestTransfer = $plugin->expand($restOrderBudgetsBulkRequestTransfer);
        }

        foreach ($restOrderBudgetsBulkRequestTransfer->getOrderBudgets() as $restOrderBudgetsBulkRequestOrderBudgetTransfer) {
            $this->eventFacade->trigger(
                OrderBudgetsBulkRestApiEvents::ASSIGNMENT_PROCESS,
                $restOrderBudgetsBulkRequestOrderBudgetTransfer,
            );

            ++$currentCount;
        }

        return (new RestOrderBudgetsBulkResponseTransfer())
            ->setIsSuccessful(true)
            ->setActualCount($actualCount)
            ->setCurrentCount($currentCount);
    }
}
