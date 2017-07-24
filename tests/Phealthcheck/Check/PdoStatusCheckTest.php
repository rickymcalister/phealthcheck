<?php
namespace Test\ManageFlitter\HealthCheck\App\Check;

use Phealthcheck\Check\PdoStatusCheck;
use Phealthcheck\Mock\PdoMock;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class PdoStatusCheckTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group        unit
     * @dataProvider runDataProvider
     * @param string|null $status
     * @param array       $expected
     */
    public function testRun($status, $expected)
    {
        $check = new PdoStatusCheck($this->getMockPdo($status));
        $this->assertEquals($expected, $check->run());
    }

    /**
     * DataProvider for testRun
     *
     * @return array
     */
    public function runDataProvider()
    {
        return [
            [
                'status'   => 'localhost',
                'expected' => ['connected' => true]
            ],
            [
                'status'   => null,
                'expected' => ['connected' => false]
            ]
        ];
    }

    /**
     * Return a basic PDO mock object
     *
     * @param string|null $status
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockPdo($status = null)
    {
        $mockPdo = $this->getMockBuilder(PdoMock::class)
            ->setMethods(['getAttribute'])
            ->getMock();

        $mockPdo->expects($this->atLeastOnce())->method('getAttribute')->willReturn($status);

        return $mockPdo;
    }
}
