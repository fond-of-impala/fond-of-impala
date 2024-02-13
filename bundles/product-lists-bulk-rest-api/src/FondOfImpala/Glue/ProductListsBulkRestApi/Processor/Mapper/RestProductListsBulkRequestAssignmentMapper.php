<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

class RestProductListsBulkRequestAssignmentMapper implements RestProductListsBulkRequestAssignmentMapperInterface
{
    protected RestProductListsBulkRequestAssignmentProductListsMapperInterface $restProductListsBulkRequestAssignmentProductListsMapper;

    /**
     * @var array<\FondOfImpala\Glue\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentMapperPluginInterface>
     */
    protected array $restProductListsBulkRequestAssignmentMapperPlugins;

    /**
     * @param \FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestAssignmentProductListsMapperInterface $restProductListsBulkRequestAssignmentProductListsMapper
     * @param array<\FondOfImpala\Glue\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentMapperPluginInterface> $restProductListsBulkRequestAssignmentMapperPlugins
     */
    public function __construct(
        RestProductListsBulkRequestAssignmentProductListsMapperInterface $restProductListsBulkRequestAssignmentProductListsMapper,
        array $restProductListsBulkRequestAssignmentMapperPlugins
    ) {
        $this->restProductListsBulkRequestAssignmentProductListsMapper = $restProductListsBulkRequestAssignmentProductListsMapper;
        $this->restProductListsBulkRequestAssignmentMapperPlugins = $restProductListsBulkRequestAssignmentMapperPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer
     */
    public function fromRestProductListsBulkAssignment(
        RestProductListsBulkAssignmentTransfer $restProductListsBulkAssignmentTransfer
    ): RestProductListsBulkRequestAssignmentTransfer {
        $restProductListsBulkRequestAssignmentTransfer = new RestProductListsBulkRequestAssignmentTransfer();

        $restProductListsBulkRequestAssignmentTransfer->setProductListsToAssign(
            $this->restProductListsBulkRequestAssignmentProductListsMapper->fromRestProductListsBulkAssignmentProductLists(
                $restProductListsBulkAssignmentTransfer->getProductListsToAssign(),
            ),
        );

        $restProductListsBulkRequestAssignmentTransfer->setProductListsToUnassign(
            $this->restProductListsBulkRequestAssignmentProductListsMapper->fromRestProductListsBulkAssignmentProductLists(
                $restProductListsBulkAssignmentTransfer->getProductListsToUnassign(),
            ),
        );

        foreach ($this->restProductListsBulkRequestAssignmentMapperPlugins as $plugin) {
            $restProductListsBulkRequestAssignmentTransfer = $plugin->mapRestProductListsBulkAssignmentToRestProductListsBulkRequestAssignment(
                $restProductListsBulkAssignmentTransfer,
                $restProductListsBulkRequestAssignmentTransfer,
            );
        }

        return $restProductListsBulkRequestAssignmentTransfer;
    }
}
