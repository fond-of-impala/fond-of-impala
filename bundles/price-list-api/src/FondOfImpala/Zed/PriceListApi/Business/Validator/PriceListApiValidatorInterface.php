<?php

namespace FondOfImpala\Zed\PriceListApi\Business\Validator;

use Generated\Shared\Transfer\ApiRequestTransfer;

interface PriceListApiValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array;
}
