<?php
/**
 * REST API Core
 *
 * @author    Evgeny Leksunin <e.leksunin@gmail.com>
 * @copyright 2017 Evgeny Leksunin
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/evgeny-l/rest-api-core
 */

namespace EvgenyL\RestAPICore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

/**
 * Class Request
 * @package EvgenyL\RestAPICore\Http\Requests
 */
abstract class Request extends FormRequest
{

    /**
     * Formatting JSON validation errors.
     *
     * @param array $errors
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        if (($this->ajax() && ! $this->pjax()) || $this->wantsJson()) {
            return new JsonResponse(['validation_errors' => $errors], 422);
        }

        return parent::response($errors);
    }

    /**
     * Checks if query string contains request of include.
     *
     * @param string $include
     * @return bool
     */
    public function hasInclude($include)
    {
        $includes = $this->get('includes');
        if (!$includes || !is_string($includes)) {
            return false;
        }
        $includes = explode(',', $includes);
        return in_array($include, $includes);
    }

    /**
     * Intersect an array of items with the input data.
     *
     * !OVERRIDED! Cause original version filters out empty strings and zero integers.
     * It's invalid behavior in case of API request. Only NULL values should go out.
     *
     * @param  array|mixed  $keys
     * @return array
     */
    public function intersect($keys)
    {
        return array_filter($this->only(is_array($keys) ? $keys : func_get_args()),
            function($value){
                return !is_null($value);
            });
    }

}
