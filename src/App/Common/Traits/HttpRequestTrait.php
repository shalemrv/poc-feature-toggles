<?php

namespace App\Common\Traits;

use Symfony\Component\HttpFoundation\Request;

trait HttpRequestTrait {

    function extractFormInputs(array &$payload, Request &$request, array &$keys) {
        
        foreach($keys as $key)
            $payload[$key] = $request->get($key);
        
    }

    function extractRawJson(array &$payload, Request &$request, array &$keys) {

        $jsonPayload = $request->getContent();

        if (!$jsonPayload)
            return;

        $jsonPayload = json_decode($jsonPayload, true);

        foreach($keys as $key) {
        
            if ($jsonPayload[$key])
                $payload[$key] = $jsonPayload[$key];

        }
    }

    /**
     * Fetch data from the request object from Form data
     * and if raw JSON of the http request
     * 
     * @param Request       $request    The Http request object
     * @param array         $keys       List of keys that need to be extracted
     * 
     * @return array|null   $payload
     */
    function extractDataFromRequest(Request &$request, $keys = []) {
        
        if (!$keys) return null;

        $payload = [];

        $this->extractFormInputs($payload, $request, $keys); // Data from Form submissions
        
        $this->extractRawJson($payload, $request, $keys); // Data from Raw Json

        return $payload;
    }
}