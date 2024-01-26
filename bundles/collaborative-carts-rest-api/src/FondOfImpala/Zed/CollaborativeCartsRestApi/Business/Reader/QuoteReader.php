<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader;

use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToQuoteFacadeInterface;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteReader implements QuoteReaderInterface
{
    protected CollaborativeCartsRestApiToQuoteFacadeInterface $quoteFacade;

    /**
     * @param \FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToQuoteFacadeInterface $quoteFacade
     */
    public function __construct(
        CollaborativeCartsRestApiToQuoteFacadeInterface $quoteFacade
    ) {
        $this->quoteFacade = $quoteFacade;
    }

    /**
     * @param string $uuid
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer|null
     */
    public function getByUuid(string $uuid): ?QuoteTransfer
    {
        $quoteResponseTransfer = $this->quoteFacade->findQuoteByUuid(
            (new QuoteTransfer())->setUuid($uuid),
        );

        $quoteTransfer = $quoteResponseTransfer->getQuoteTransfer();

        if ($quoteTransfer === null || $quoteResponseTransfer->getIsSuccessful() === false) {
            return null;
        }

        return $quoteTransfer;
    }
}
