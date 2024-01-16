<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Updater;

use ArrayObject;
use FondOfImpala\Shared\CompanyUserCartsRestApi\CompanyUserCartsRestApiConstants;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Exception\QuoteNotUpdatedException;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpanderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Throwable;

class QuoteUpdater implements QuoteUpdaterInterface
{
    use TransactionTrait;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface
     */
    protected QuoteFinderInterface $quoteFinder;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpanderInterface
     */
    protected QuoteExpanderInterface $quoteExpander;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface
     */
    protected QuoteHandlerInterface $quoteHandler;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface
     */
    protected WritePermissionCheckerInterface $writePermissionChecker;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface
     */
    protected CompanyUserCartsRestApiToQuoteFacadeInterface $quoteFacade;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface $quoteFinder
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpanderInterface $quoteExpander
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface $quoteHandler
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface $writePermissionChecker
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface $quoteFacade
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        QuoteFinderInterface $quoteFinder,
        QuoteExpanderInterface $quoteExpander,
        QuoteHandlerInterface $quoteHandler,
        WritePermissionCheckerInterface $writePermissionChecker,
        CompanyUserCartsRestApiToQuoteFacadeInterface $quoteFacade,
        LoggerInterface $logger
    ) {
        $this->quoteFinder = $quoteFinder;
        $this->quoteExpander = $quoteExpander;
        $this->quoteHandler = $quoteHandler;
        $this->quoteFacade = $quoteFacade;
        $this->logger = $logger;
        $this->writePermissionChecker = $writePermissionChecker;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @throws \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Exception\QuoteNotUpdatedException
     * @throws \Throwable
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function updateByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        $self = $this;
        $restCompanyUserCartsResponseTransfer = null;

        try {
            $this->getTransactionHandler()->handleTransaction(
                static function () use ($restCompanyUserCartsRequestTransfer, &$restCompanyUserCartsResponseTransfer, $self): void {
                    $restCompanyUserCartsResponseTransfer = $self->executeUpdateByRestCompanyUserCartsRequest(
                        $restCompanyUserCartsRequestTransfer,
                    );

                    if ($restCompanyUserCartsResponseTransfer->getIsSuccessful()) {
                        return;
                    }

                    throw new QuoteNotUpdatedException('Quote could not be updated.');
                },
            );
        } catch (QuoteNotUpdatedException $exception) {
        } catch (Throwable $exception) {
            $this->logger->error('Quote could not be updated.', [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $restCompanyUserCartsRequestTransfer->serialize()]);

            throw $exception;
        }

        return $restCompanyUserCartsResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    protected function executeUpdateByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        if (!$this->writePermissionChecker->checkByRestCompanyUserCartsRequest($restCompanyUserCartsRequestTransfer)) {
            $quoteErrorTransfer = (new QuoteErrorTransfer())
                ->setMessage(CompanyUserCartsRestApiConstants::ERROR_MESSAGE_PERMISSION_DENIED);

            return (new RestCompanyUserCartsResponseTransfer())->setIsSuccessful(false)
                ->setErrors(new ArrayObject([$quoteErrorTransfer]));
        }

        $restCompanyUserCartsResponseTransfer = $this->quoteFinder->findOneByRestCompanyUserCartsRequest(
            $restCompanyUserCartsRequestTransfer,
        );

        $quoteTransfer = $restCompanyUserCartsResponseTransfer->getQuote();

        if ($quoteTransfer === null || !$restCompanyUserCartsResponseTransfer->getIsSuccessful()) {
            return $restCompanyUserCartsResponseTransfer;
        }

        $quoteTransfer = $this->quoteExpander->expand($quoteTransfer, $restCompanyUserCartsRequestTransfer);

        $restCompanyUserCartsResponseTransfer = $this->quoteHandler->handle(
            $quoteTransfer,
            $restCompanyUserCartsRequestTransfer,
        );

        $quoteTransfer = $restCompanyUserCartsResponseTransfer->getQuote();

        if (
            $quoteTransfer === null
            || $quoteTransfer->getIdQuote() === null
            || !$restCompanyUserCartsResponseTransfer->getIsSuccessful()
        ) {
            return $restCompanyUserCartsResponseTransfer;
        }

        $quoteResponseTransfer = $this->quoteFacade->updateQuote($quoteTransfer);
        $quoteTransfer = $quoteResponseTransfer->getQuoteTransfer();

        if (
            $quoteTransfer === null
            || $quoteTransfer->getIdQuote() === null
            || !$quoteResponseTransfer->getIsSuccessful()
        ) {
            return (new RestCompanyUserCartsResponseTransfer())->setIsSuccessful(false)
                ->setErrors($quoteResponseTransfer->getErrors());
        }

        return $this->quoteFinder->findByIdQuote($quoteTransfer->getIdQuote());
    }
}
