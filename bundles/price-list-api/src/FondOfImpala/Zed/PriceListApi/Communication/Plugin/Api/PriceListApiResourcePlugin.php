<?php

namespace FondOfImpala\Zed\PriceListApi\Communication\Plugin\Api;

use FondOfImpala\Zed\PriceListApi\PriceListApiConfig;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\Api\ApiConfig;
use Spryker\Zed\Api\Business\Exception\ApiDispatchingException;
use Spryker\Zed\Api\Dependency\Plugin\ApiResourcePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PriceListApi\PriceListApiConfig getConfig()
 * @method \FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiQueryContainerInterface getQueryContainer()
 */
class PriceListApiResourcePlugin extends AbstractPlugin implements ApiResourcePluginInterface
{
    /**
     * @api
     *
     * @return string
     */
    public function getResourceName(): string
    {
        return PriceListApiConfig::RESOURCE_PRICE_LISTS;
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function add(ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        return $this->getFacade()->addPriceList($apiDataTransfer);
    }

    /**
     * @api
     *
     * @param int $id
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function get($id): ApiItemTransfer
    {
        return $this->getFacade()->getPriceList($id);
    }

    /**
     * @api
     *
     * @param int $id
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update($id, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        return $this->getFacade()->updatePriceList($id, $apiDataTransfer);
    }

    /**
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
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        return $this->getFacade()->findPriceLists($apiRequestTransfer);
    }
}
