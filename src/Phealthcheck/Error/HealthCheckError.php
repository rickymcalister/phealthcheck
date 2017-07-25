<?php
namespace Phealthcheck\Error;

use Phealthcheck\Check\Enum\CheckStatus;
use Symfony\Component\HttpFoundation\JsonResponse;

class HealthCheckError
{
    /**
     * Build and send a health check error response
     *
     * @param string $message
     * @param int    $code
     * @return JsonResponse
     */
    public static function getResponse($message = '', $code = 0)
    {
        return new JsonResponse(['status' => CheckStatus::FAIL, 'error' => ['message' => $message, 'code' => $code]]);
    }
}
