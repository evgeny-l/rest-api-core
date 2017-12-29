<?php
/**
 * REST API Core
 *
 * @author    Evgeny Leksunin <e.leksunin@gmail.com>
 * @copyright 2017 Evgeny Leksunin
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/evgeny-l/rest-api-core
 */

namespace EvgenyL\RestAPICore\Http\Middleware;

use Closure;
use EvgenyL\RestAPICore\Http\Responses\FormattedJSONResponse;
use Illuminate\Http\Response;

/**
 * Class ResponseFormat
 * Used to format JSON response for API.
 * @package EvgenyL\RestAPICore\Http\Middleware
 */
class ResponseFormat
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if (! $response instanceof FormattedJsonResponse) {
            if ($request->ajax() || $request->wantsJson()) {
                if ($response->headers->get('content-type') === 'application/json') {
                    $content = $response->getContent();
                    $content = json_decode($content, true);
                    $responseData = [
                        'meta' => [
                            'status_code' => $response->getStatusCode(),
                            'message'     => '',
                        ],
                        'data' => $content
                    ];
                    $response->setContent(json_encode($responseData));
                }
            }
        }

        return $response;
    }

}
