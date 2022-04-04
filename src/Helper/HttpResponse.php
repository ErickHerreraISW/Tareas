<?php

namespace App\Helper;

use App\Exception\UnexpectedParamsException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use \Exception;

class HttpResponse
{
    /**
     * @param $data
     * @return JsonResponse
     */
    public static function success($data) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 200, array(), true);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public static function created($data) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 201, array(), true);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public static function void($data) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 204, array(), true);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public static function accepted($data) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 202, array(), true);
    }

    public static function conflict($data = null) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 209, array(), true);
    }

    /**
     * @param null $data
     * @return JsonResponse
     */
    public static function failed($data = null) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 417, array(), true);
    }

    /**
     * @param null $data
     * @return JsonResponse
     */
    public static function notFound($data = null) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 404, array(), true);
    }

    /**
     * @param null $data
     * @return JsonResponse
     */
    public static function unAuthorized($data = null) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 401, array(), true);
    }

    /**
     * @param null $data
     * @return JsonResponse
     */
    public static function gone($data = null) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 410, array(), true);
    }

    /**
     * @param Exception $data
     * @return JsonResponse
     */
    public static function serverError(Exception $data) : JsonResponse
    {
        $data_response = array(
            "errorClass" => get_class($data),
            "message"    => $data->getMessage(),
            "errorLine"  => $data->getLine(),
            "errorFile"  => $data->getFile()
        );

        if($data instanceof UnexpectedParamsException) {
            $data_response['details'] = $data->getDetails();
        }

        $data_response = json_encode($data_response);

        return new JsonResponse($data_response, 500, array(), true);
    }

    /**
     * @param null $data
     * @return JsonResponse
     */
    public static function forbidden($data = null) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 403, array(), true);
    }

    /**
     * @param null $data
     * @return JsonResponse
     */
    public static function badRequest($data = null) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 400, array(), true);
    }

    /**
     * @param null $data
     * @return JsonResponse
     */
    public static function notAcceptable($data = null) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data_response = $serializer->serialize(array("data" => $data), "json");

        return new JsonResponse($data_response, 406, array(), true);
    }

    public static function customResponse($status, $data, $ex = null) : JsonResponse
    {
        switch ($status){
            case 200: return self::success($data);
                break;
            case 201: return self::created($data);
                break;
            case 204: return self::void($data);
                break;
            case 400: return self::badRequest();
                break;
            case 401: return self::unauthorized();
                break;
            case 403: return self::forbidden();
                break;
            case 404: return self::notFound();
                break;
            case 409: return self::conflict();
                break;
            case 417: return self::failed();
                break;
            case 500: return self::serverError($ex);
                break;
        }

        return self::success($data);
    }
}