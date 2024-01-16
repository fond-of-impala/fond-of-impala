<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader;

use Generated\Shared\Transfer\QuoteTransfer;

interface QuoteReaderInterface
{
    /**
     * @param string $uuid
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer|null
     */
    public function getByUuid(string $uuid): ?QuoteTransfer;
}
