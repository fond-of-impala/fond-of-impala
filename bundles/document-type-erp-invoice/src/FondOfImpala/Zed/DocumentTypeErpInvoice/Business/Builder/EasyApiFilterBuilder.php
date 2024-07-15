<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Business\Builder;

use ArrayObject;
use FondOfImpala\Zed\DocumentTypeErpInvoice\DocumentTypeErpInvoiceConfig;
use FondOfImpala\Zed\DocumentTypeErpInvoice\Persistence\DocumentTypeErpInvoiceRepositoryInterface;
use FondOfOryx\Shared\EasyApi\EasyApiConstants;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterConditionTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Generated\Shared\Transfer\ErpInvoiceTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Symfony\Component\HttpFoundation\Response;

class EasyApiFilterBuilder implements EasyApiFilterBuilderInterface
{
    protected DocumentTypeErpInvoiceConfig $config;

    protected DocumentTypeErpInvoiceRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\DocumentTypeErpInvoice\Persistence\DocumentTypeErpInvoiceRepositoryInterface $repository
     * @param \FondOfImpala\Zed\DocumentTypeErpInvoice\DocumentTypeErpInvoiceConfig $config
     */
    public function __construct(
        DocumentTypeErpInvoiceRepositoryInterface $repository,
        DocumentTypeErpInvoiceConfig $config
    ) {
        $this->repository = $repository;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function build(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer
    {
        $transfer = new EasyApiFilterTransfer();

        $erpInvoice = $this->repository->getErpInvoiceWithPermissionCheck($documentRequestTransfer);

        if ($erpInvoice === null) {
            return $transfer->setError($this->createErrorMessage('Invoice document not found or missing permissions!', Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return $transfer
            ->setStores([$this->config->getEasyApiStore()])
            ->setConditions($this->createConditions($erpInvoice));
    }

    /**
     * @param \Generated\Shared\Transfer\ErpInvoiceTransfer $erpInvoiceTransfer
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\EasyApiFilterConditionTransfer>
     */
    protected function createConditions(ErpInvoiceTransfer $erpInvoiceTransfer): ArrayObject
    {
        $conditions = new ArrayObject();

        $conditions->append((new EasyApiFilterConditionTransfer())
            ->setField(EasyApiConstants::FIELD_NAME_DOCUMENT_NUMBER)
            ->setValue($erpInvoiceTransfer->getDocumentNumber()));

        return $conditions;
    }

    /**
     * @param string $message
     * @param int $code
     *
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    protected function createErrorMessage(string $message, int $code): MessageTransfer
    {
        return (new MessageTransfer())
            ->setMessage($message)
            ->setType('error')
            ->setValue((string)$code);
    }
}
