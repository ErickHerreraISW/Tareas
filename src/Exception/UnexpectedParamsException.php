<?php

namespace App\Exception;

class UnexpectedParamsException extends \Exception
{
    const UNRECOGNIZED_PARAMS = "Uno o más parámetros de entrada no corresponden con los esperados por el servicio";

    public $details;

    /**
     * UnexpectedParamsException constructor.
     * @param $details
     * @param null $message
     */
    public function __construct($details, $message = null)
    {
        parent::__construct();
        $this->details = $details;

        if($message != null) {
            $this->message = $message;
        }
        else {
            $this->message = self::UNRECOGNIZED_PARAMS;
        }
    }


    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }
}