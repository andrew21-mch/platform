<?php

namespace Ushahidi\App\Http\Controllers\API;

use Ushahidi\App\Http\Controllers\RESTController;

/**
 * Ushahidi API CountryCodes Controller
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */
class CountryCodesController extends RESTController
{
    protected function getResource()
    {
        return 'country_codes';
    }
}
