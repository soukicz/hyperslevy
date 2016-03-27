<?php
namespace Hyperslevy\Response;

abstract class AbstractResponse {

    /**
     * @var integer
     */
    private $httpCode;

    /**
     * @var boolean
     */
    private $result;

    /**
     * @param array $responseData Response data
     * @param integer $httpCode Response HTTP status code
     */
    final public function __construct(array $responseData, $httpCode) {
        $this->result = $responseData['result'];
        $this->httpCode = $httpCode;
        $this->parseResponseData($responseData);
    }

    /**
     * @return boolean
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * @return integer
     */
    public function getHttpCode() {
        return $this->httpCode;
    }

    /**
     * @return array
     */
    abstract public function getData();

    /**
     * @param array $responseData Response data
     */
    abstract protected function parseResponseData(array $responseData);

}
