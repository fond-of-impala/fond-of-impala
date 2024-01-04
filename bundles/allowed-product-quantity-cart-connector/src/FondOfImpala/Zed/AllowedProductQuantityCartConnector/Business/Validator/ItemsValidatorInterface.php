<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator;

use ArrayObject;

interface ItemsValidatorInterface
{
    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\MessageTransfer>>
     */
    public function validate(ArrayObject $itemTransfers): ArrayObject;

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\ItemTransfer>
     */
    public function validateAndAppendResult(ArrayObject $itemTransfers): ArrayObject;
}
