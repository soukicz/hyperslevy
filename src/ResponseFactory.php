<?php
namespace Hyperslevy;

use Hyperslevy\Response\AbstractResponse;
use Hyperslevy\Response\FailureResponse;
use Hyperslevy\Response\SuccessResponse;

class ResponseFactory {

    /**
     * @param string $responseData
     * @param integer $httpCode
     * @return AbstractResponse
     * @throws \RuntimeException
     */
    public static function create($responseData, $httpCode) {
        $parsedResponse = json_decode($responseData, true);
        if(null === $parsedResponse) {
            $message = sprintf('Could not parse the JSON response from the API "%s".', $responseData);
            throw new \RuntimeException($message, function_exists('json_last_error') ? json_last_error() : 0);
        }

        if(!isset($parsedResponse['result'], $parsedResponse['data'], $parsedResponse['error']) || !is_bool($parsedResponse['result'])) {
            throw new \RuntimeException('The response has an invalid structure.');
        }

        if($parsedResponse['result']) {
            if(!is_array($parsedResponse['data'])) {
                throw new \RuntimeException('The response has an invalid structure. The "data" part has to be an array.');
            }
        } else {
            if(!isset($parsedResponse['error']['code'], $parsedResponse['error']['message'])) {
                $message = 'The response has an invalid structure. The returned error has to have both the code and the message.';
                throw new \RuntimeException($message);
            }
        }

        if($parsedResponse['result']) {
            return new SuccessResponse($parsedResponse, $httpCode);
        } else {
            return new FailureResponse($parsedResponse, $httpCode);
        }

    }

}
