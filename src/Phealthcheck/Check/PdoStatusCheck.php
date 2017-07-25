<?php
namespace Phealthcheck\Check;

use PDO;
use Phealthcheck\Check\Enum\CheckStatus;

final class PdoStatusCheck implements CheckInterface
{
    /** @var PDO */
    private $connection;

    /**
     * PdoStatusCheck constructor.
     *
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return a valid CheckStatus
     *
     * @return CheckStatus
     */
    public function run()
    {
        return $this->checkPdoConnection($this->connection) ? CheckStatus::OK() : CheckStatus::FAIL();
    }

    /**
     * Check the PDO connection status
     *
     * Return false if the connection status is NULL, otherwise return true.
     *
     * @param PDO $connection
     * @return bool
     */
    private function checkPdoConnection(PDO $connection)
    {
        return !is_null($connection->getAttribute(PDO::ATTR_CONNECTION_STATUS));
    }
}
