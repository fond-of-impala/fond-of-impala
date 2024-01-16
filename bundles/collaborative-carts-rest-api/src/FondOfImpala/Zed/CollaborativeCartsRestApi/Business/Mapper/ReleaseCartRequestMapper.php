<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper;

use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;

class ReleaseCartRequestMapper implements ReleaseCartRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ReleaseCartRequestTransfer
     */
    public function fromRestReleaseCartRequest(
        RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
    ): ReleaseCartRequestTransfer {
        return (new ReleaseCartRequestTransfer())->fromArray(
            $restReleaseCartRequestTransfer->toArray(),
            true,
        );
    }
}
