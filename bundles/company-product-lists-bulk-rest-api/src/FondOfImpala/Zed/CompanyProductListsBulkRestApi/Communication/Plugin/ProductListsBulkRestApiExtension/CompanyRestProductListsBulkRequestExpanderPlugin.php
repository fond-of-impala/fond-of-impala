<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Communication\Plugin\ProductListsBulkRestApiExtension;

use FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestExpanderPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\CompanyProductListsBulkRestApiFacadeInterface getFacade()
 */
class CompanyRestProductListsBulkRequestExpanderPlugin extends AbstractPlugin implements RestProductListsBulkRequestExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    public function expand(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkRequestTransfer {
        return $this->getFacade()->expandRestProductListsBulkRequest($restProductListsBulkRequestTransfer);
    }
}
