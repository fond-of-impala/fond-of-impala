<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder;

use FondOfImpala\Shared\CompanyUserCartsRestApi\CompanyUserCartsRestApiConstants;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\ReadPermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReaderInterface;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;

class QuoteFinder implements QuoteFinderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReaderInterface
     */
    protected QuoteReaderInterface $quoteReader;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\ReadPermissionCheckerInterface
     */
    protected ReadPermissionCheckerInterface $readPermissionChecker;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReaderInterface $quoteReader
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\ReadPermissionCheckerInterface $readPermissionChecker
     */
    public function __construct(
        QuoteReaderInterface $quoteReader,
        ReadPermissionCheckerInterface $readPermissionChecker
    ) {
        $this->quoteReader = $quoteReader;
        $this->readPermissionChecker = $readPermissionChecker;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function findOneByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        if (!$this->readPermissionChecker->checkByRestCompanyUserCartsRequest($restCompanyUserCartsRequestTransfer)) {
            $quoteErrorTransfer = (new QuoteErrorTransfer())
                ->setMessage(CompanyUserCartsRestApiConstants::ERROR_MESSAGE_PERMISSION_DENIED);

            return (new RestCompanyUserCartsResponseTransfer())->setIsSuccessful(false)
                ->addError($quoteErrorTransfer);
        }

        $quoteTransfer = $this->quoteReader->getByRestCompanyUserCartsRequest($restCompanyUserCartsRequestTransfer);

        return $this->handleFoundQuote($quoteTransfer);
    }

    /**
     * @param int $idQuote
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function findByIdQuote(int $idQuote): RestCompanyUserCartsResponseTransfer
    {
        $quoteTransfer = $this->quoteReader->getByIdQuote($idQuote);

        return $this->handleFoundQuote($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer|null $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    protected function handleFoundQuote(?QuoteTransfer $quoteTransfer): RestCompanyUserCartsResponseTransfer
    {
        if ($quoteTransfer !== null) {
            return (new RestCompanyUserCartsResponseTransfer())
                ->setIsSuccessful(true)
                ->setQuote($quoteTransfer);
        }

        $quoteErrorTransfer = (new QuoteErrorTransfer())
            ->setMessage(CompanyUserCartsRestApiConstants::ERROR_MESSAGE_QUOTE_NOT_FOUND);

        return (new RestCompanyUserCartsResponseTransfer())
            ->setIsSuccessful(false)
            ->addError($quoteErrorTransfer);
    }
}
