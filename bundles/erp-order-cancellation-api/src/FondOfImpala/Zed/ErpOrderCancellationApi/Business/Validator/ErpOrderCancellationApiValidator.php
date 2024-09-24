<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Business\Validator;

use Generated\Shared\Transfer\ApiRequestTransfer;

class ErpOrderCancellationApiValidator implements ErpOrderCancellationApiValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array
    {
        return [];
    }
}
