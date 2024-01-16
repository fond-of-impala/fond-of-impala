<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper;

use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;

interface ReleaseCartRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ReleaseCartRequestTransfer
     */
    public function fromRestReleaseCartRequest(
        RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
    ): ReleaseCartRequestTransfer;
}
