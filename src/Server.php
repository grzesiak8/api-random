<?php
namespace RestApi;

class Server {

    private array $operations;
    private Response $response;

    public function checkAuthorization()
    {
        $headers = getallheaders();

        if (isset($headers['X-TOKEN']) && $headers['X-TOKEN'] === '12345') {
            return true;
        }
        $this->response = new Response(401, [], false);
        $this->sendResponse();
    }
    
    public function addOperartion($uri, $class, $parameter = [])
    {
        $this->operations[$uri] = [
            'class' => $class,
            'parameter' => $parameter,
        ];
    }
    public function handleRequest()
    {
        foreach($this->operations as $uri => $operationData) {
            if (strpos($_SERVER['REQUEST_URI'], $uri) !== false) {
                if ($operationData['parameter'] === []) {
                    $call = new $operationData['class']();
                    $this->response = $call();
                    return;
                } else {
                    $call = new $operationData['class']();
                    $$operationData['parameter'] = $this->getParameter($operationData['parameter']);
                    if ($$operationData['parameter'] === null) {
                        $this->displayError('Not valid parameters');
                        return;
                    }
                    $this->response = $call($$operationData['parameter']);
                    return;
                }
            }
            
        }
        $this->displayError('Bad operation');
        return;
    }

    public function sendResponse()
    {
        $this->response->send();
    }

    private function getParameter($name)
    {
        $parsedQuery = parse_url($_SERVER['REQUEST_URI'])['query'];
        foreach (explode('&', $parsedQuery) as $query) {
            $paramName = explode('=', $query)[0];
            $paramVal = explode('=', $query)[1];
            $pattern  = $name[$paramName];
            preg_match($pattern, $query, $matches);
            if ($matches) {
                return $paramVal;
            }
        }
        return null;
    }

    private function displayError($msg)
    {
        $this->response = new Response(
            400, 
            [
                'status' => 'ERROR',
                'msg' => $msg,
            ], 
            true
        );
    }
}