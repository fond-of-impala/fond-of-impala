<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade;

use Generated\Shared\Transfer\ApiItemTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\Api\Business\ApiFacadeInterface;

class ConditionalAvailabilityBulkApiToApiFacadeBridge implements
    ConditionalAvailabilityBulkApiToApiFacadeInterface
{
    /**
     * @var \Spryker\Zed\Api\Business\ApiFacadeInterface
     */
    protected $apiFacade;

    /**
     * @param \Spryker\Zed\Api\Business\ApiFacadeInterface $apiFacade
     */
    public function __construct(ApiFacadeInterface $apiFacade)
    {
        $this->apiFacade = $apiFacade;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|null $transfer
     * @param string|null $id
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function createApiItem(?AbstractTransfer $transfer = null, ?string $id = null): ApiItemTransfer
    {
        return $this->apiFacade->createApiItem($transfer, $id);
    }
}
