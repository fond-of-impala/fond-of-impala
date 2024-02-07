<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor;

use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\ProductListsBulkRestApiEvents;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;

class BulkProcessor implements BulkProcessorInterface
{
    protected ProductListsBulkRestApiToEventFacadeInterface $eventFacade;

    protected array $restProductListsBulkRequestExpanderPlugins;

    /**
     * @param \FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface $eventFacade
     * @param array<\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestExpanderPluginInterface> $restProductListsBulkRequestExpanderPlugins
     */
    public function __construct(
        ProductListsBulkRestApiToEventFacadeInterface $eventFacade,
        array $restProductListsBulkRequestExpanderPlugins
    ) {
        $this->eventFacade = $eventFacade;
        $this->restProductListsBulkRequestExpanderPlugins = $restProductListsBulkRequestExpanderPlugins;
    }


    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer
     */
    public function process(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkResponseTransfer {
        foreach ($this->restProductListsBulkRequestExpanderPlugins as $plugin) {
            $restProductListsBulkRequestTransfer = $plugin->expand($restProductListsBulkRequestTransfer);
        }

        foreach ($restProductListsBulkRequestTransfer->getAssignments() as $restProductListsBulkRequestAssignmentTransfer) {
            $this->eventFacade->trigger(
                ProductListsBulkRestApiEvents::ASSIGNMENT_PROCESS,
                $restProductListsBulkRequestAssignmentTransfer
            );
        }

        return (new RestProductListsBulkResponseTransfer())->setIsSuccessful(true);
    }
}
