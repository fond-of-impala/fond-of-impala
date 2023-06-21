<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Communication\Plugin\Api;

use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\ConditionalAvailabilityBulkApiConfig;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\Api\ApiConfig;
use Spryker\Zed\Api\Business\Exception\ApiDispatchingException;
use Spryker\Zed\Api\Dependency\Plugin\ApiResourcePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\ConditionalAvailabilityBulkApiConfig getConfig()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\ConditionalAvailabilityBulkApiFacadeInterface getFacade()
 */
class ConditionalAvailabilityBulkApiResourcePlugin extends AbstractPlugin implements ApiResourcePluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceName(): string
    {
        return ConditionalAvailabilityBulkApiConfig::RESOURCE_CONDITIONAL_AVAILABILITIES_BULK;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function add(ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        return $this->getFacade()->persistConditionalAvailabilities($apiDataTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $id
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function get($id): ApiItemTransfer
    {
        throw new ApiDispatchingException('Get action is not implemented yet.', ApiConfig::HTTP_CODE_NOT_FOUND);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $id
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update($id, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        throw new ApiDispatchingException('Update action is not implemented yet.', ApiConfig::HTTP_CODE_NOT_FOUND);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $id
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function remove($id): ApiItemTransfer
    {
        throw new ApiDispatchingException('Remove action is not implemented yet.', ApiConfig::HTTP_CODE_NOT_FOUND);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        throw new ApiDispatchingException('Find action is not implemented yet.', ApiConfig::HTTP_CODE_NOT_FOUND);
    }
}
