<?php

namespace FondOfImpala\Shared\CompanyUsersBulkRestApi;

interface CompanyUsersBulkRestApiConstants
{
    /**
     * @var string
     */
    public const INDEX_CUSTOMER = 'customer';

    /**
     * @var string
     */
    public const INDEX_COMPANIES = 'companies';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_MISSING_PERMISSION = 'Missing permission to create bulk company user!';

    /**
     * @var int
     */
    public const ERROR_CODE_PERMISSION_DENIED = 422;

    /**
     * @var int
     */
    public const SUCCESS_CODE = 200;

    /**
     * @var int
     */
    public const ERROR_CODE = 500;

    /**
     * @var string
     */
    public const BULK_ASSIGN = 'BULK_ASSIGN';

    /**
     * @var string
     */
    public const BULK_UNASSIGN = 'BULK_UNASSIGN';
}
