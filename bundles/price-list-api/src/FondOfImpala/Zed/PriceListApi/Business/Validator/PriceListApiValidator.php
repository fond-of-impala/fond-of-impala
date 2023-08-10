<?php

namespace FondOfImpala\Zed\PriceListApi\Business\Validator;

use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\ApiValidationErrorTransfer;

class PriceListApiValidator implements PriceListApiValidatorInterface
{
    /**
     * @var string
     */
    protected const KEY_NAME = 'name';

    /**
     * @var string
     */
    protected const KEY_PRICE_LIST_ENTRIES = 'price_list_entries';

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array
    {
        $apiData = $apiRequestTransfer->getApiDataOrFail()->getData();

        $apiValidationErrorTransfers = $this->assertRequiredField($apiData, static::KEY_NAME, []);

        return $this->assertRequiredField($apiData, static::KEY_PRICE_LIST_ENTRIES, $apiValidationErrorTransfers);
    }

    /**
     * @param array<string, mixed> $data
     * @param string $field
     * @param array<\Generated\Shared\Transfer\ApiValidationErrorTransfer> $apiValidationErrorTransfers
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    protected function assertRequiredField(array $data, string $field, array $apiValidationErrorTransfers): array
    {
        if (!isset($data[$field]) || (array_key_exists($field, $data) && !$data[$field])) {
            $message = sprintf('Missing value for required field "%s"', $field);
            $apiValidationErrorTransfers[] = $this->createApiValidationErrorTransfer($field, [$message]);
        }

        return $apiValidationErrorTransfers;
    }

    /**
     * @param string $field
     * @param array<string> $messages
     *
     * @return \Generated\Shared\Transfer\ApiValidationErrorTransfer
     */
    protected function createApiValidationErrorTransfer(string $field, array $messages): ApiValidationErrorTransfer
    {
        return (new ApiValidationErrorTransfer())
            ->setField($field)
            ->setMessages($messages);
    }
}
