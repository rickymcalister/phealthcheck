<?php
namespace Phealthcheck;

use Phealthcheck\Check\CheckInterface;
use Phealthcheck\Check\Enum\CheckStatus;
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
                    'database'   => $this->getCheckMock(CheckStatus::OK())
                ],
                'expected' => '{"status":"OK","database":"OK"}'
            ],
            [
                'checks'   => [
                    'database'   => $this->getCheckMock(CheckStatus::FAIL())
                ],
                'expected' => '{"status":"FAIL","database":"FAIL"}'
            ],
            [
                'checks'   => [
                    'primary_db' => $this->getCheckMock(CheckStatus::FAIL()),
                    'secondary_db'   => $this->getCheckMock(CheckStatus::FAIL())
                ],
                'expected' => '{"status":"FAIL","primary_db":"FAIL","secondary_db":"FAIL"}'
            ],
            [
                'checks'   => [
                    'primary_db' => $this->getCheckMock(CheckStatus::OK()),
                    'secondary_db'   => $this->getCheckMock(CheckStatus::FAIL())
                ],
                'expected' => '{"status":"FAIL","primary_db":"OK","secondary_db":"FAIL"}'
            ],
            [
                'checks'   => [
                    'primary_db' => $this->getCheckMock(CheckStatus::FAIL()),
                    'secondary_db'   => $this->getCheckMock(CheckStatus::OK())
                ],
                'expected' => '{"status":"FAIL","primary_db":"FAIL","secondary_db":"OK"}'
            ],
            [
                'checks'   => [
                    'primary_db' => $this->getCheckMock(CheckStatus::OK()),
                    'secondary_db'   => $this->getCheckMock(CheckStatus::OK())
                ],
                'expected' => '{"status":"OK","primary_db":"OK","secondary_db":"OK"}'
            ]
        ];
    }

    /**
     * @param CheckStatus $status
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getCheckMock($status)
    {
        $mockCheck = $this->getMock(CheckInterface::class);
        $mockCheck->expects($this->atLeastOnce())->method('run')->willReturn($status);

        return $mockCheck;
    }
}
