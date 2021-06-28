<?php
namespace RestApi;

class Response {

    private int $code;
    private array $data;
    private bool $isJson;

    public function __construct(int $code, array $data, bool $isJson) {

        $this->code = $code;
        $this->data = $data;
        $this->isJson = $isJson;
    }

    public function send() {

        header("HTTP/1.1 " . $this->code);
        if ($this->isJson) {
            header('Content-Type: application/json');
        }
        if ($this->data !== []) {
            echo json_encode($this->data);
        }
        exit;
    }
}