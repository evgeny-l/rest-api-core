<?php
/**
 * REST API Core
 *
 * @author    Evgeny Leksunin <e.leksunin@gmail.com>
 * @copyright 2017 Evgeny Leksunin
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/evgeny-l/rest-api-core
 */

namespace EvgenyL\RestAPICore\Http\Exceptions;

use EvgenyL\RestAPICore\Http\Responses\FormattedJSONResponse;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Trait APIJSONHandlerTrait
 * @package EvgenyL\RestAPICore\Http\Exceptions
 */
trait APIJSONHandlerTrait
{

    public function handleJSONResponse($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);
        $data = [];
        $message = $exception->getMessage();
        $code = $exception->getCode();
        if ($exception instanceof HttpException) {
            $code = $exception->getStatusCode();
        }
        elseif ($exception instanceof ValidationException) {
            $code = 422;
            $data = $exception->validator->errors()->getMessages();
        } elseif ($exception instanceof AuthenticationException) {
            $code = 401;
        } elseif ($exception instanceof AuthorizationException) {
            $code = 403;
        }
        if ($code < 100 || $code >= 600) {
            $code = 500;
        } elseif ($code == 405) {
            $message = 'Method not allowed.';
        }
        return FormattedJSONResponse::error($code, $message, $data);
    }

}