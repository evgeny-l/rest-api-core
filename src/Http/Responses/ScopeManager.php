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

use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Serializer\SerializerAbstract;
use EvgenyL\RestAPICore\Http\Requests\APIRequest;
use EvgenyL\RestAPICore\Http\Serializers\EntitySerializer;

/**
 * Class ScopeManager
 * @package EvgenyL\RestAPICore\Http\Responses
 */
class ScopeManager extends Manager
{

    /** @var Request|null */
    private $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
        if ($request && $request instanceof APIRequest) {
            $includes = $request->query('includes');
            if (is_string($includes)) {
                $this->parseIncludes($includes);
            }
        }
    }

    /**
     * Get Serializer.
     *
     * @return SerializerAbstract
     */
    public function getSerializer()
    {
        if (! $this->serializer) {
            $this->setSerializer(new EntitySerializer());
        }
        return $this->serializer;
    }
}