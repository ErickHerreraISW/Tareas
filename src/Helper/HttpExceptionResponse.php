<?php

namespace App\Helper;

use App\Exception\AuthenticateException;
use App\Exception\BadFormatException;
use App\Exception\FailedException;
use App\Exception\ForbiddenException;
use App\Exception\NeedToReloadException;
use App\Exception\NoContentException;
use App\Exception\UnexpectedParamsException;
use App\Exception\UnexpectedParamsValueException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Exception;

class HttpExceptionResponse
{
    /**
     * @param Exception $exception
     * @return JsonResponse
     */
    public static function response(Exception $exception) : JsonResponse
    {
        if($exception instanceof AuthenticateException) {
            return HttpResponse::unAuthorized($exception->getMessage());
        }

        if($exception instanceof NotFoundHttpException) {
            return HttpResponse::notFound($exception->getMessage());
        }

        if($exception instanceof ForbiddenException) {
            return HttpResponse::forbidden($exception->getMessage());
        }

        if($exception instanceof BadFormatException) {
            return HttpResponse::badRequest($exception->getMessage());
        }

        if($exception instanceof UnexpectedParamsException) {
            return HttpResponse::serverError($exception);
        }

        if($exception instanceof UnexpectedParamsValueException) {
            return HttpResponse::serverError($exception);
        }

        if($exception instanceof NeedToReloadException) {
            return HttpResponse::badRequest($exception->getMessage());
        }

        if($exception instanceof FailedException) {
            return HttpResponse::failed($exception->getMessage());
        }

        if($exception instanceof NoContentException) {
            return HttpResponse::void($exception->getMessage());
        }

        return HttpResponse::serverError($exception);
    }
}