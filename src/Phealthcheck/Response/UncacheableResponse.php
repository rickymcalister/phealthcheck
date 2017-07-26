<?php
namespace Phealthcheck\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class UncacheableResponse extends JsonResponse
{
    /**
     * UncacheableResponse constructor.
     *
     * @param null  $data
     * @param int   $status
     * @param array $headers
     * @param bool  $json
     */
    public function __construct($data = null, $status = 200, array $headers = [], $json = false)
    {
        parent::__construct($data, $status, $headers, $json);

        $this->setCacheHeaders();
    }

    /**
     * Set response headers to ensure the response is not cached
     */
    private function setCacheHeaders()
    {
        $this->headers->set(
            'Cache-Control',
            ['no-store', 'no-cache', 'must-revalidate', 'max-age=0',]
        );
        $this->headers->set('Cache-Control', ['post-check=0', 'pre-check=0',], false);
        $this->headers->set('Pragma', ['no-cache',]);
    }
}
