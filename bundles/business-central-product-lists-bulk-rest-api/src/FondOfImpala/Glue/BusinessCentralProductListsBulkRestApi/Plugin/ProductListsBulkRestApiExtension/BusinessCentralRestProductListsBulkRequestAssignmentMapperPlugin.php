<?php

namespace FondOfImpala\Glue\BusinessCentralProductListsBulkRestApi\Plugin\ProductListsBulkRestApiExtension;

use FondOfImpala\Glue\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentMapperPluginInterface;
use Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentCompanyTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

class BusinessCentralRestProductListsBulkRequestAssignmentMapperPlugin extends AbstractPlugin implements RestProductListsBulkRequestAssignmentMapperPluginInterface
{
 /**
  * @param \Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransfer
  * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
  *
  * @return \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer
  */
    public function mapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment(
        RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransfer,
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): RestProductListsBulkRequestAssignmentTransfer {
        $restProductListsBulkAssignmentCompanyTransfer = $restProductListsBulkAssignmentTransfer->getCompany();

        if ($restProductListsBulkAssignmentCompanyTransfer === null) {
            return $restProductListsBulkRequestAssignmentTransfer;
        }

        $restProductListsBulkRequestAssignmentCompanyTransfer = $restProductListsBulkRequestAssignmentTransfer->getCompany();
        if ($restProductListsBulkRequestAssignmentCompanyTransfer === null) {
            $restProductListsBulkRequestAssignmentCompanyTransfer = new RestProductListsBulkRequestAssignmentCompanyTransfer();
        }

        $restProductListsBulkRequestAssignmentCompanyTransfer = $restProductListsBulkRequestAssignmentCompanyTransfer->setDebtorNumber(
            $restProductListsBulkAssignmentCompanyTransfer->getDebtorNumber(),
        );

        return $restProductListsBulkRequestAssignmentTransfer->setCompany(
            $restProductListsBulkRequestAssignmentCompanyTransfer,
        );
    }
}
