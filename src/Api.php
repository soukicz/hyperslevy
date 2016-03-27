<?php
namespace Hyperslevy;

use GuzzleHttp\Client;
use Hyperslevy\Response\AbstractResponse;
use Hyperslevy\Response\SuccessResponse;

class Api {

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    const CZ = 'hyperslevy.cz';

    /**
     * @var string
     */
    private $hash;

    /**
     * @param mixed $server
     * @param mixed $hash
     */
    public function __construct($server, $hash) {
        if($server !== self::CZ) {
            throw new \RuntimeException(sprintf('An invalid server was provided: "%s".', $server));
        }
        $this->httpClient = new Client([
            'base_uri' => sprintf('http://www.%s/api', $server),
            'exceptions' => false,
        ]);
        $this->hash = $hash;
    }

    /**
     * Checks if a voucher is valid.
     * Returns TRUE if the checked voucher exists and can be used, FALSE otherwise.
     * The whole response object will be stored in the second parameter.
     *
     * @param string $code
     * @param AbstractResponse $response
     * @return boolean
     */
    public function checkVoucher($code, &$response = null) {
        $response = $this->performRequest('voucherCheck.php', ['hash' => $this->hash, 'code' => $code]);
        return $response instanceof SuccessResponse;
    }

    /**
     * Tries to apply a voucher.
     * Returns TRUE if the voucher was successfully applied, FALSE otherwise.
     * The whole response object will be stored in the second parameter.
     *
     * @param string $code
     * @param AbstractResponse $response
     * @return boolean
     */
    public function applyVoucher($code, &$response = null) {
        $response = $this->performRequest('voucherApply.php', ['hash' => $this->hash, 'code' => $code]);
        return $response instanceof SuccessResponse;
    }

    /**
     * @param string $action
     * @param array $parameters
     * @return AbstractResponse
     * @throws \RuntimeException
     */
    protected function performRequest($action, array $parameters) {
        $response = $this->httpClient->get($action, [
            'query' => $parameters
        ]);

        return ResponseFactory::create((string)$response->getBody(), $response->getStatusCode());
    }

}
