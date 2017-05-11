<?php
/**
 * REST API Core
 *
 * @author    Evgeny Leksunin <e.leksunin@gmail.com>
 * @copyright 2017 Evgeny Leksunin
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/evgeny-l/rest-api-core
 */

namespace EvgenyL\RestAPICore\Http\Responses;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class FormattedJSONResponse
 * @package EvgenyL\RestAPICore\Http\Responses
 */
class FormattedJSONResponse extends JsonResponse
{

    public static function list($data, $message = '', $code = self::HTTP_OK)
    {
        $meta = [
            'status_code' => $code,
            'message' => $message,
            'pagination' => (isset($data['meta']) && isset($data['meta']['pagination'])) ? $data['meta']['pagination'] : [],
        ];
        if (isset($data['meta'])) {
            $meta = array_merge($meta, $data['meta']);
        }
        $data = [
            'meta' => $meta,
            'data' => $data['data'],
        ];
        return parent::create($data, $code);
    }

    public static function show($data, $message = '')
    {
        $data = [
            'meta' => [
                'status_code' => self::HTTP_OK,
                'message' => $message,
            ],
            'data' => $data,
        ];
        return parent::create($data, self::HTTP_OK);
    }

    public static function created($data, $message = 'Resource created.')
    {
        $data = [
            'meta' => [
                'status_code' => self::HTTP_CREATED,
                'message' => $message,
            ],
            'data' => $data,
        ];
        return parent::create($data, self::HTTP_CREATED);
    }

    public static function updated($data, $message = 'Resource updated.')
    {
        $data = [
            'meta' => [
                'status_code' => self::HTTP_OK,
                'message' => $message,
            ],
            'data' => $data,
        ];
        return parent::create($data, self::HTTP_OK);
    }

    public static function deleted($data = [], $message = 'Resource deleted.')
    {
        $data = [
            'meta' => [
                'status_code' => self::HTTP_OK,
                'message' => $message,
            ],
            'data' => $data,
        ];
        return parent::create($data, self::HTTP_OK);
    }

    public static function error($code, $message = 'Error occurred.', $data = [])
    {
        $data = [
            'meta' => [
                'status_code' => $code,
                'message' => $message,
            ],
            'data' => $data,
        ];
        return parent::create($data, $code);
    }

    public static function valuesList($data, $message = 'List of possible values.')
    {
        $responseData = [];
        foreach ($data as $type=>$name) {
            $responseData[] = [
                'value' => $type,
                'text' => $name,
            ];
        }
        return self::show($responseData, $message);
    }

}