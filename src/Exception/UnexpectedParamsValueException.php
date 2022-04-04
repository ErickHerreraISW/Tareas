<?php

namespace App\Exception;

class UnexpectedParamsValueException extends \Exception
{
    const UNRECOGNIZED_PARAMS_VALUE = "Uno o más valores de uno o más parámetros no existe definido por el servicio";
    public $details;

    /**
     * UnexpectedParamsValueException constructor.
     * @param $details
     */
    public function __construct($details)
    {
        parent::__construct();
        $this->details = $details;
        $this->message = self::UNRECOGNIZED_PARAMS_VALUE;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }
}