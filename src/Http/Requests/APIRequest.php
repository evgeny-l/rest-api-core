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

/**
 * Class APIRequest
 * @package EvgenyL\RestAPICore\Http\Requests
 */
class APIRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return $this->getTraitRules();
    }

    protected function getTraitRules()
    {
        $class = static::class;
        if ($class === self::class) {
            return array();
        }
        $rules = array();
        foreach (class_uses_recursive($class) as $trait) {
            if (method_exists($this, $method = class_basename($trait).'Rules')) {
                $traitRules = $this->{$method}();
                $intersectedRules = array_intersect_key($rules, $traitRules);
                if (!empty($intersectedRules)) {
                    throw new \Exception('Trait '.$trait.' has conflicting rules for attributes: '.json_encode($intersectedRules));
                }
                $rules = array_merge($rules, $traitRules);
            }
        }
        return $rules;
    }

}