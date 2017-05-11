<?php
/**
 * REST API Core
 *
 * @author    Evgeny Leksunin <e.leksunin@gmail.com>
 * @copyright 2017 Evgeny Leksunin
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/evgeny-l/rest-api-core
 */

namespace EvgenyL\RestAPICore\Http\Transformers;

/**
 * Class FormatDates
 * @package EvgenyL\RestAPICore\Http\Transformers
 *
 * Formatting response dates according to current API request.
 */
trait FormatDates
{

    public function isodate(\Carbon\Carbon $date = null)
    {
        if ($date === null) {
            return null;
        }
        return $date->copy()->setTimezone('UTC')->toIso8601String();
    }

}