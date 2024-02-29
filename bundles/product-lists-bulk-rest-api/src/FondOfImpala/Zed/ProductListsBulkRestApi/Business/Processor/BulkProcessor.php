<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor;

use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker\RestProductListsBulkRequestAssignmentCheckerInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\ProductListsBulkRestApiEvents;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use Throwable;

class BulkProcessor implements BulkProcessorInterface
{
    protected RestProductListsBulkRequestAssignmentCheckerInterface $restProductListsBulkRequestAssignmentChecker;

    protected ProductListsBulkRestApiToEventFacadeInterface $eventFacade;

    protected array $restProductListsBulkRequestExpanderPlugins;

    /**
     * @param \FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker\RestProductListsBulkRequestAssignmentCheckerInterface $restProductListsBulkRequestAssignmentChecker
     * @param \FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface $eventFacade
     * @param array<\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestExpanderPluginInterface> $restProductListsBulkRequestExpanderPlugins
     */
    public function __construct(
        RestProductListsBulkRequestAssignmentCheckerInterface $restProductListsBulkRequestAssignmentChecker,
        ProductListsBulkRestApiToEventFacadeInterface $eventFacade,
        array $restProductListsBulkRequestExpanderPlugins
    ) {
        $this->eventFacade = $eventFacade;
        $this->restProductListsBulkRequestExpanderPlugins = $restProductListsBulkRequestExpanderPlugins;
        $this->restProductListsBulkRequestAssignmentChecker = $restProductListsBulkRequestAssignmentChecker;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer
     */
    public function process(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkResponseTransfer {
        try {
            return $this->executeProcess($restProductListsBulkRequestTransfer);
        } catch (Throwable) {
            return (new RestProductListsBulkResponseTransfer())
                ->setIsSuccessful(false);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer
     */
    protected function executeProcess(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkResponseTransfer {
        $invalidIndexes = [];

        foreach ($this->restProductListsBulkRequestExpanderPlugins as $plugin) {
            $restProductListsBulkRequestTransfer = $plugin->expand($restProductListsBulkRequestTransfer);
        }

        foreach ($restProductListsBulkRequestTransfer->getAssignments() as $index => $restProductListsBulkRequestAssignmentTransfer) {
            $preCheckResult = $this->restProductListsBulkRequestAssignmentChecker->preCheck(
                $restProductListsBulkRequestAssignmentTransfer,
            );

            if (!$preCheckResult) {
                $invalidIndexes[] = $index;

                continue;
            }

            $this->eventFacade->trigger(
                ProductListsBulkRestApiEvents::ASSIGNMENT_PROCESS,
                $restProductListsBulkRequestAssignmentTransfer,
            );
        }

        return (new RestProductListsBulkResponseTransfer())
            ->setIsSuccessful(true)
            ->setInvalidIndexes($invalidIndexes);
    }
}
