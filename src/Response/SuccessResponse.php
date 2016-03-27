<?php
namespace Hyperslevy\Response;

class SuccessResponse extends AbstractResponse implements \IteratorAggregate {

    /**
     * @var array
     */
    private $data;

    /**
     * @param array $responseData Response data
     */
    protected function parseResponseData(array $responseData) {
        $this->data = $responseData['data'];
    }

    /**
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new \ArrayIterator($this->data);
    }

}
