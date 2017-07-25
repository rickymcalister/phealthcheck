<?php
namespace Phealthcheck;

use Phealthcheck\Check\CheckInterface;
use Phealthcheck\Check\Enum\CheckStatus;
use Symfony\Component\HttpFoundation\JsonResponse;

final class HealthCheck
{
    /** @var CheckInterface[] */
    protected $checks;

    /**
     * HealthCheck constructor
     *
     * @param CheckInterface[] $checks
     */
    public function __construct(array $checks = [])
    {
        $this->checks = $checks;
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
     * Build a JSON response
     *
     * @return JsonResponse
     */
    public function getResponse()
    {
        $responseData = ['status' => CheckStatus::OK];

        foreach ($this->checks as $checkName => $check) {
            $result = $check->run();

            if ($result === CheckStatus::FAIL()) {
                $responseData['status'] = CheckStatus::FAIL;
            }

            $responseData[$checkName] = $result->value();
        }

        return new JsonResponse($responseData);
    }
}
