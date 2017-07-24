<?php
namespace Phealthcheck;

use Phealthcheck\Check\CheckInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class HealthCheck
{
    /** @var JsonResponse */
    protected $response;

    /**
     * HealthCheck constructor
     *
     * @param CheckInterface[] $checks
     */
    public function __construct(array $checks = [])
    {
        $this->checks = $checks;

        $this->buildResponse();
    }

    /**
     * Return the JSON response
     *
     * @return JsonResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Build and return a JSON response
     *
     * @return JsonResponse
     */
    private function buildResponse()
    {
        $responseData = ['success' => true];

        foreach ($this->checks as $checkName => $check) {
            $responseData[$checkName] = $check->run();
        }

        $this->response = new JsonResponse($responseData);
    }
}
