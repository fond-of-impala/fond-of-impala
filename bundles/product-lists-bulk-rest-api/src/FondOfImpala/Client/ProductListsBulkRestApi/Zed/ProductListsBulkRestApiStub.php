<?php

namespace FondOfImpala\Client\ProductListsBulkRestApi\Zed;

use FondOfImpala\Client\ProductListsBulkRestApi\Dependency\Client\ProductListsBulkRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;

class ProductListsBulkRestApiStub implements ProductListsBulkRestApiStubInterface
{
    /**
     * @var string
     */
    public const BULK_PROCESS = '/product-lists-bulk-rest-api/gateway/bulk-process';

    protected ProductListsBulkRestApiToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\ProductListsBulkRestApi\Dependency\Client\ProductListsBulkRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ProductListsBulkRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer
     */
    public function bulkProcess(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer $restProductListsBulkResponseTransfer */
        $restProductListsBulkResponseTransfer = $this->zedRequestClient->call(
            static::BULK_PROCESS,
            $restProductListsBulkRequestTransfer,
        );

        return $restProductListsBulkResponseTransfer;
    }
}
