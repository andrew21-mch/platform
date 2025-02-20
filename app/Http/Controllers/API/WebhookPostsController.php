<?php

namespace Ushahidi\App\Http\Controllers\API;

/**
 * Ushahidi API External Webhook Posts Controller
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @copyright  2013 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

use Illuminate\Http\Request;
use Ushahidi\Core\Tools\Signer;
use Ushahidi\App\Http\Controllers\API\Posts\PostsController;

class WebhookPostsController extends PostsController
{
    /**
     * Update An Entity
     *
     * PUT /api/foo/:id
     *
     * @return void
     */
    public function update(Request $request)
    {
        $this->usecase = $this->usecaseFactory
            ->get($this->getResource(), 'webhook-update')
            ->setIdentifiers($this->getIdentifiers($request))
            ->setPayload($this->getPayload($request));

        return $this->prepResponse($this->executeUsecase($request), $request);
    }
}
