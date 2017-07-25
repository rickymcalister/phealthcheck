<?php
namespace Phealthcheck\Check\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class CheckStatus
 *
 * @package Phealthcheck\Check\Enum
 *
 * @method static CheckStatus FAIL()
 * @method static CheckStatus OK()
 */
final class CheckStatus extends AbstractEnumeration
{
    const FAIL = 'FAIL';
    const OK   = 'OK';
}
