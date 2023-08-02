<?php

declare(strict_types = 1);

namespace FondOfImpala\Shared\CompanyUsersRestApi;

class CompanyUsersRestApiConfig
{
    /**
     * @var string
     */
    public const RESPONSE_CODE_COMPANY_USER_DATA_INVALID = '1300';

    /**
     * @var string
     */
    public const RESPONSE_CODE_COMPANY_NOT_FOUND = '1302';

    /**
     * @var string
     */
    public const RESPONSE_CODE_ACCESS_DENIED = '1303';

    /**
     * @var string
     */
    public const RESPONSE_CODE_FAILED_DELETING_COMPANY_USER = '1304';

    /**
     * @var string
     */
    public const RESPONSE_CODE_COMPANY_USER_ALREADY_EXIST = '1305';

    /**
     * @var string
     */
    public const RESPONSE_CODE_COULD_NOT_CREATE_CUSTOMER = '1306';

    /**
     * @var string
     */
    public const RESPONSE_CODE_COMPANY_ROLE_NOT_FOUND = '1307';

    /**
     * @var string
     */
    public const RESPONSE_CODE_COMPANY_USER_NOT_FOUND = '1308';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_COMPANY_USER_DATA_INVALID = 'Company user data is invalid.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_COMPANY_NOT_FOUND = 'Company not found.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_ACCESS_DENIED = 'Access Denied';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_FAILED_DELETING_COMPANY_USER = 'Could not delete company user.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_COMPANY_USER_ALREADY_EXIST = 'Company user already exists.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_COULD_NOT_CREATE_CUSTOMER = 'Could not create or assign existing customer.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_COMPANY_ROLE_NOT_FOUND = 'Company role not found.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_COMPANY_USER_NOT_FOUND = 'Company user not found.';
}
