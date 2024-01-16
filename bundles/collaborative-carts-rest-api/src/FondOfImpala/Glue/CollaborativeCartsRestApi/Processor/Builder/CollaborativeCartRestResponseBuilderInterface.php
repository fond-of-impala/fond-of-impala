<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface CollaborativeCartRestResponseBuilderInterface
{
    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createInvalidActionErrorResponse(): RestResponseInterface;

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCartIdMissingErrorResponse(): RestResponseInterface;

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createNotClaimedErrorResponse(): RestResponseInterface;

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createNotReleasedErrorResponse(): RestResponseInterface;

    /**
     * @param string $action
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createRestResponse(string $action, QuoteTransfer $quoteTransfer): RestResponseInterface;
}
