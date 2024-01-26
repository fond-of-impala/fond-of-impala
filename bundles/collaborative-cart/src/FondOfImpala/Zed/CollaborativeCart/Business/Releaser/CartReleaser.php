<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Releaser;

use Exception;
use FondOfImpala\Zed\CollaborativeCart\Business\Exception\QuoteCouldNotBeReleasedException;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteReaderInterface;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteWriterInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\ReleaseCartResponseTransfer;

class CartReleaser implements CartReleaserInterface
{
    protected QuoteReaderInterface $quoteReader;

    protected QuoteWriterInterface $quoteWriter;

    /**
     * @param \FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteReaderInterface $quoteReader
     * @param \FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteWriterInterface $quoteWriter
     */
    public function __construct(
        QuoteReaderInterface $quoteReader,
        QuoteWriterInterface $quoteWriter
    ) {
        $this->quoteReader = $quoteReader;
        $this->quoteWriter = $quoteWriter;
    }

    /**
     * @param \Generated\Shared\Transfer\ReleaseCartRequestTransfer $releaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ReleaseCartResponseTransfer
     */
    public function release(ReleaseCartRequestTransfer $releaseCartRequestTransfer): ReleaseCartResponseTransfer
    {
        try {
            $releaseCartResponseTransfer = $this->doRelease($releaseCartRequestTransfer);
        } catch (Exception $exception) {
            $releaseCartResponseTransfer = (new ReleaseCartResponseTransfer())
                ->setIsSuccess(false)
                ->setError($exception->getMessage());
        }

        return $releaseCartResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ReleaseCartRequestTransfer $releaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ReleaseCartResponseTransfer
     */
    protected function doRelease(ReleaseCartRequestTransfer $releaseCartRequestTransfer): ReleaseCartResponseTransfer
    {
        $quoteTransfer = $this->getQuoteByReleaseCartRequest($releaseCartRequestTransfer);

        $companyUserReference = $quoteTransfer->getOriginalCompanyUserReference();
        $customerReference = $quoteTransfer->getOriginalCustomerReference();

        $quoteTransfer->setOriginalCompanyUserReference(null)
            ->setOriginalCustomerReference(null)
            ->setCompanyUserReference($companyUserReference)
            ->setCustomerReference($customerReference)
            ->setCustomer((new CustomerTransfer())->setCustomerReference($customerReference));

        return (new ReleaseCartResponseTransfer())
            ->setIsSuccess(true)
            ->setQuote($this->updateQuote($quoteTransfer));
    }

    /**
     * @param \Generated\Shared\Transfer\ReleaseCartRequestTransfer $releaseCartRequestTransfer
     *
     * @throws \FondOfImpala\Zed\CollaborativeCart\Business\Exception\QuoteCouldNotBeReleasedException
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function getQuoteByReleaseCartRequest(ReleaseCartRequestTransfer $releaseCartRequestTransfer): QuoteTransfer
    {
        $quoteTransfer = $this->quoteReader->getByReleaseCartRequest($releaseCartRequestTransfer);

        if ($quoteTransfer === null) {
            throw new QuoteCouldNotBeReleasedException('Could not find quote to release.');
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @throws \FondOfImpala\Zed\CollaborativeCart\Business\Exception\QuoteCouldNotBeReleasedException
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function updateQuote(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $quoteTransfer = $this->quoteWriter->update($quoteTransfer);

        if ($quoteTransfer === null) {
            throw new QuoteCouldNotBeReleasedException('Could not update quote.');
        }

        return $quoteTransfer;
    }
}
