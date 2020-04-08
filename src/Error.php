<?php

namespace WA\ErrorHandler;

class Error
{
    private $err;
    private $ref;
    private $data;

    public function __construct($err = null, $ref = null, ...$args)
    {
        $this->err = $err;
        $this->ref = $ref;
        $this->data = $args;

        $this->save();

        $this->print();

        exit;
    }

    private function print()
    {
        $error = array(
            "error" => $this->err,
            "method" => $this->ref,
            "data" => $this->data,
        );
    
        $json = json_encode($error, JSON_PRETTY_PRINT);
        print_r($json);
    }

    private function save()
    {
        $date = date("m/d/Y - h:i:s a");
        $err = is_array($this->err) ? json_encode($this->err) : $this->err;
        $err = is_string($err) ? $err : "";
        $data = json_encode($this->data);

        $line = $date . "\t\t\t" . $this->ref . "\t\t\t" . $err . "\t\t\t" . $data . "\n";

        return file_put_contents('error.log', $line, FILE_APPEND);
    }
}
