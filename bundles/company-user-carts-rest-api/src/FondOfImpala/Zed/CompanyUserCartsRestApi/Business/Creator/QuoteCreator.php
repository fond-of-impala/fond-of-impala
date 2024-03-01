<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Creator;

use ArrayObject;
use FondOfImpala\Shared\CompanyUserCartsRestApi\CompanyUserCartsRestApiConstants;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Exception\QuoteNotCreatedException;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpanderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\QuoteMapperInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApiExtension\Dependency\Plugin\QuoteCreateExpanderPluginInterface;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Throwable;

class QuoteCreator implements QuoteCreatorInterface
{
    use TransactionTrait;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface
     */
    protected CompanyUserReaderInterface $companyUserReader;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\QuoteMapperInterface
     */
    protected QuoteMapperInterface $quoteMapper;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface
     */
    protected QuoteHandlerInterface $quoteHandler;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface
     */
    protected QuoteFinderInterface $quoteFinder;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface
     */
    protected WritePermissionCheckerInterface $writePermissionChecker;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface
     */
    protected CompanyUserCartsRestApiToQuoteFacadeInterface $quoteFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpanderInterface
     */
    protected QuoteCreateExpanderInterface $quoteCreateExpander;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\QuoteMapperInterface $quoteMapper
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface $quoteHandler
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface $quoteFinder
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface $writePermissionChecker
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface $quoteFacade
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpanderInterface $quoteCreateExpander
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        CompanyUserReaderInterface                    $companyUserReader,
        QuoteMapperInterface                          $quoteMapper,
        QuoteHandlerInterface                         $quoteHandler,
        QuoteFinderInterface                          $quoteFinder,
        WritePermissionCheckerInterface               $writePermissionChecker,
        CompanyUserCartsRestApiToQuoteFacadeInterface $quoteFacade,
        QuoteCreateExpanderInterface                  $quoteCreateExpander,
        LoggerInterface                               $logger
    )
    {
        $this->companyUserReader = $companyUserReader;
        $this->quoteMapper = $quoteMapper;
        $this->quoteHandler = $quoteHandler;
        $this->quoteFinder = $quoteFinder;
        $this->writePermissionChecker = $writePermissionChecker;
        $this->quoteFacade = $quoteFacade;
        $this->quoteCreateExpander = $quoteCreateExpander;
        $this->logger = $logger;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     * @throws \Throwable
     *
     * @throws \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Exception\QuoteNotCreatedException
     */
    public function createByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer
    {
        $self = $this;
        $restCompanyUserCartsResponseTransfer = null;

        try {
            $this->getTransactionHandler()->handleTransaction(
                static function () use ($restCompanyUserCartsRequestTransfer, &$restCompanyUserCartsResponseTransfer, $self): void {
                    $restCompanyUserCartsResponseTransfer = $self->executeCreateByRestCompanyUserCartsRequest(
                        $restCompanyUserCartsRequestTransfer,
                    );

                    if ($restCompanyUserCartsResponseTransfer->getIsSuccessful()) {
                        return;
                    }

                    throw new QuoteNotCreatedException('Quote could not be created.');
                },
            );
        } catch (QuoteNotCreatedException $exception) {
        } catch (Throwable $exception) {
            $this->logger->error('Quote could not be created.', [
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
    protected function executeCreateByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer
    {
        $companyUserTransfer = $this->companyUserReader->getByRestCompanyUserCartsRequest(
            $restCompanyUserCartsRequestTransfer,
        );

        if ($companyUserTransfer === null) {
            $quoteErrorTransfer = (new QuoteErrorTransfer())
                ->setMessage(CompanyUserCartsRestApiConstants::ERROR_MESSAGE_COMPANY_USER_NOT_FOUND);

            return (new RestCompanyUserCartsResponseTransfer())->setIsSuccessful(false)
                ->setErrors(new ArrayObject([$quoteErrorTransfer]));
        }

        if (!$this->writePermissionChecker->checkByCompanyUser($companyUserTransfer)) {
            $quoteErrorTransfer = (new QuoteErrorTransfer())
                ->setMessage(CompanyUserCartsRestApiConstants::ERROR_MESSAGE_PERMISSION_DENIED);

            return (new RestCompanyUserCartsResponseTransfer())->setIsSuccessful(false)
                ->setErrors(new ArrayObject([$quoteErrorTransfer]));
        }

        $quoteTransfer = $this->quoteMapper->fromRestCompanyUserCartsRequest($restCompanyUserCartsRequestTransfer)
            ->setCompanyUser($companyUserTransfer);

        try {
            $quoteTransfer = $this->quoteCreateExpander->expand($quoteTransfer, $restCompanyUserCartsRequestTransfer);
        } catch (Throwable $throwable) {
            $quoteErrorTransfer = (new QuoteErrorTransfer())
                ->setMessage($throwable->getCode() === QuoteCreateExpanderPluginInterface::ERROR_CODE ? $throwable->getMessage() : CompanyUserCartsRestApiConstants::ERROR_MESSAGE_QUOTE_CREATE_EXPANDER_UNEXPECTED);

            return (new RestCompanyUserCartsResponseTransfer())->setIsSuccessful(false)
                ->setErrors(new ArrayObject([$quoteErrorTransfer]));
        }

        $quoteResponseTransfer = $this->quoteFacade->createQuote($quoteTransfer);
        $quoteTransfer = $quoteResponseTransfer->getQuoteTransfer();

        if (
            $quoteTransfer === null
            || $quoteTransfer->getIdQuote() === null
            || !$quoteResponseTransfer->getIsSuccessful()
        ) {
            return (new RestCompanyUserCartsResponseTransfer())->setIsSuccessful(false)
                ->setErrors($quoteResponseTransfer->getErrors());
        }

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
