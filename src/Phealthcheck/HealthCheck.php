<?php
namespace Phealthcheck;

use Phealthcheck\Check\CheckInterface;
use Phealthcheck\Check\Enum\CheckStatus;
use Symfony\Component\HttpFoundation\JsonResponse;

final class HealthCheck
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
     * @param string         $name
     * @param CheckInterface $check
     * @todo Validate $name (e.g. alphanumeric, max-length)
     *
     * @return $this
     */
    public function addCheck($name, CheckInterface $check)
    {
        $this->checks[$name] = $check;

        return $this;
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
     * Build a JSON response
     */
    private function buildResponse()
    {
        $responseData = ['status' => CheckStatus::OK];

        foreach ($this->checks as $checkName => $check) {
            $result = $check->run();

            if ($result === CheckStatus::FAIL()) {
                $responseData['status'] = CheckStatus::FAIL;
            }

            $responseData[$checkName] = $result->value();
        }

        $this->response = new JsonResponse($responseData);
    }
}
