<?php
namespace Phealthcheck\Check;

use Phealthcheck\Check\Enum\CheckStatus;

/**
 * Interface CheckInterface
 *
 * A valid Check MUST implement this interface.
 *
 * Only expected constant values should be returned in the check results, no variable values should be returned, e.g.
 *
 * DO: confirm if a connection can be established to a particular service
 * DON'T: check the number of jobs ready in a specific beanstalkd queue
 *
 * @package PhealthCheck\Check
 */
interface CheckInterface
{
    /**
     * Return a valid CheckStatus
     *
     * @return CheckStatus
     */
    public function run();
}
