<?php

namespace FondOfImpala\Client\ProductListsBulkRestApi;

use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;

class ProductListsBulkRestApiClient implements ProductListsBulkRestApiClientInterface
{
 /**
  * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
  *
  * @return \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer
  */
    public function bulkProcess(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkResponseTransfer {
        // TODO: Implement bulkProcess() method.
    }
}
