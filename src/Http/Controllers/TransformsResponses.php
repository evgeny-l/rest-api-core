<?php
/**
 * REST API Core
 *
 * @author    Evgeny Leksunin <e.leksunin@gmail.com>
 * @copyright 2017 Evgeny Leksunin
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/evgeny-l/rest-api-core
 */

namespace EvgenyL\RestAPICore\Http\Controllers\API;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use EvgenyL\RestAPICore\Http\Responses\ScopeManager;
use EvgenyL\RestAPICore\Http\Requests\APIRequest;
use League\Fractal\TransformerAbstract;

/**
 * Class TransformsResponses
 * @package EvgenyL\RestAPICore\Http\Controllers\API
 */
trait TransformsResponses
{
    /** @var TransformerAbstract */
    private $modelTransformer;

    /**
     * Return model transformer.
     *
     * @return TransformerAbstract
     */
    public function getModelTransformer(): TransformerAbstract
    {
        return $this->modelTransformer;
    }

    /**
     * Sets current model transformer.
     *
     * @param TransformerAbstract $modelTransformer
     * @return $this
     */
    public function setModelTransformer(TransformerAbstract $modelTransformer)
    {
        $this->modelTransformer = $modelTransformer;
        return $this;
    }

    /**
     * @param Request|null $request
     * @param Model $model
     * @param bool|string $includes
     * @return array
     */
    protected function convertModelJsonData(Request $request = null, Model $model, $includes = false)
    {
        $manager = new ScopeManager($request);
        if ($includes) {
            $manager->parseIncludes($includes);
        }
        $item = new Item($model, $this->getModelTransformer());
        $data = $manager->createData($item)->toArray();
        return $data;
    }

    /**
     * @param APIRequest $request
     * @param LengthAwarePaginator $paginator
     * @param bool|string $includes
     * @return array
     */
    protected function convertPaginatorJsonData(APIRequest $request, LengthAwarePaginator $paginator, $includes = false)
    {
        $models = $paginator->items();
        $items = new Collection($models, $this->getModelTransformer());
        $items->setPaginator(new IlluminatePaginatorAdapter($paginator));
        $manager = new ScopeManager($request);
        if ($includes) {
            $manager->parseIncludes($includes);
        }
        $data = $manager->createData($items)->toArray();
        return $data;
    }

    /**
     * @param APIRequest $request
     * @param array|\Illuminate\Database\Eloquent\Collection $collection
     * @param bool|string $includes
     * @return array
     */
    protected function convertCollectionJsonData(APIRequest $request, $collection, $includes = false)
    {
        $items = new Collection($collection, $this->getModelTransformer());
        $manager = new ScopeManager($request);
        if ($includes) {
            $manager->parseIncludes($includes);
        }
        $data = $manager->createData($items)->toArray();
        return $data;
    }
    
}