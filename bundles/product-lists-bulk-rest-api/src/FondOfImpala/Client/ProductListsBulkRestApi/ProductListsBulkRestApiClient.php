<?php

namespace FondOfImpala\Client\ProductListsBulkRestApi;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\ProductListsBulkRestApi\ProductListsBulkRestApiFactory getFactory()
 */
class ProductListsBulkRestApiClient extends AbstractClient implements ProductListsBulkRestApiClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer
     */
    public function bulkProcess(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkResponseTransfer {
        return $this->getFactory()
            ->createZedProductListsBulkRestApiStub()
            ->bulkProcess($restProductListsBulkRequestTransfer);
    }
}
