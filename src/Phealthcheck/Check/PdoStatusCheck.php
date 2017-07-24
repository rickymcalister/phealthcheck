<?php
namespace Phealthcheck\Check;

use PDO;

class PdoStatusCheck implements CheckInterface
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
     * Return an array containing the results of the check, e.g.
     *
     * ['connected' => true]
     *
     * @return array
     */
    public function run()
    {
        return ['connected' => $this->checkPdoConnection($this->connection)];
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
