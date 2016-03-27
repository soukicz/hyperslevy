<?php
namespace Hyperslevy\Response;

class FailureResponse extends AbstractResponse {

    /**
     * @var array
     */
    private $data;

    /**
     * @var integer
     */
    private $errorCode = 0;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @param array $responseData Response data
     */
    protected function parseResponseData(array $responseData) {
        $this->data = $responseData['error'];
        $this->errorCode = $this->data['code'];
        $this->errorMessage = $this->data['message'];
    }

    /**
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @return integer
     */
    public function getCode() {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getMessage() {
        return $this->errorMessage;
    }

}
