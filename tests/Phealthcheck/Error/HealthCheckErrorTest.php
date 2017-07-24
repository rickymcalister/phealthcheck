<?php
namespace Phealthcheck\Error;

use PHPUnit_Framework_TestCase;

class HealthCheckErrorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group        unit
     * @dataProvider sendResponseDataProvider
     * @param string $message
     * @param int    $code
     * @param string $expected
     */
    public function testSendResponse($message, $code, $expected)
    {
        $response = HealthCheckError::getResponse($message, $code);

        $this->assertEquals($expected, $response->getContent());
    }

    /**
     * @group unit
     */
    public function testDefaultSendResponse()
    {
        $expected = '{"success":false,"error":{"message":"","code":0}}';
        $response = HealthCheckError::getResponse();

        $this->assertEquals($expected, $response->getContent());
    }

    /**
     * DataProvider for testSendResponse
     *
     * @return array
     */
    public function sendResponseDataProvider()
    {
        return [
            [
                'message'  => '',
                'code'     => 0,
                'expected' => '{"success":false,"error":{"message":"","code":0}}'
            ],
            [
                'message'  => 'some message',
                'code'     => 101,
                'expected' => '{"success":false,"error":{"message":"some message","code":101}}'
            ]
        ];
    }
}
