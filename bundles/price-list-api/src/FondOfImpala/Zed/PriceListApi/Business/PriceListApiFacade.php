<?php

namespace FondOfImpala\Zed\PriceListApi\Business;

use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\PriceListApi\Business\PriceListApiBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiRepositoryInterface getRepository()
 */
class PriceListApiFacade extends AbstractFacade implements PriceListApiFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function addPriceList(ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        return $this->getFactory()->createProductListApi()->add($apiDataTransfer);
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
    public function updatePriceList(int $id, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        return $this->getFactory()->createProductListApi()->update($id, $apiDataTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfer
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function hydratePriceProductsWithProductIds(array $priceProductTransfer): array
    {
        return $this->getFactory()->createPriceProductsHydrator()->hydrate($priceProductTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idPriceList
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function getPriceList(int $idPriceList): ApiItemTransfer
    {
        return $this->getFactory()->createProductListApi()->get($idPriceList);
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
    public function findPriceLists(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        return $this->getFactory()->createProductListApi()->find($apiRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array
    {
        return $this->getFactory()->createPriceListApiValidator()->validate($apiRequestTransfer);
    }
}
