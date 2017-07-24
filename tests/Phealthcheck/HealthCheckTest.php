<?php
namespace Phealthcheck;

use Phealthcheck\Check\CheckInterface;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class HealthCheckTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group        unit
     * @dataProvider buildResponseDataProvider
     * @param array  $checks
     * @param string $expected
     */
    public function testBuildResponse($checks, $expected)
    {
        $healthCheck = new HealthCheck($checks);
        $response = $healthCheck->getResponse();

        $this->assertEquals($expected, $response->getContent());
    }

    /**
     * DataProvider for testBuildResponse
     *
     * @return array
     */
    public function buildResponseDataProvider()
    {
        return [
            [
                'checks'   => [
                    'primary_db' => $this->getCheckMock(false),
                    'shard_db'   => $this->getCheckMock(false)
                ],
                'expected' => '{"success":true,"primary_db":{"connected":false},"shard_db":{"connected":false}}'
            ],
            [
                'checks'   => [
                    'primary_db' => $this->getCheckMock(true),
                    'shard_db'   => $this->getCheckMock(false)
                ],
                'expected' => '{"success":true,"primary_db":{"connected":true},"shard_db":{"connected":false}}'
            ],
            [
                'checks'   => [
                    'primary_db' => $this->getCheckMock(false),
                    'shard_db'   => $this->getCheckMock(true)
                ],
                'expected' => '{"success":true,"primary_db":{"connected":false},"shard_db":{"connected":true}}'
            ],
            [
                'checks'   => [
                    'primary_db' => $this->getCheckMock(true),
                    'shard_db'   => $this->getCheckMock(true)
                ],
                'expected' => '{"success":true,"primary_db":{"connected":true},"shard_db":{"connected":true}}'
            ],
            [
                'checks'   => [
                    'bad_pdo_check' => $this->getCheckMock(false),
                    'good_pdo_check'   => $this->getCheckMock(true),
                    'another_good_pdo_check'   => $this->getCheckMock(true)
                ],
                'expected' => '{"success":true,"bad_pdo_check":{"connected":false},"good_pdo_check":{"connected":true},"another_good_pdo_check":{"connected":true}}'
            ]
        ];
    }

    /**
     * @param bool $connected
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getCheckMock($connected = true)
    {
        $mockCheck = $this->getMock(CheckInterface::class);
        $mockCheck->expects($this->atLeastOnce())->method('run')->willReturn(['connected' => $connected]);

        return $mockCheck;
    }
}
