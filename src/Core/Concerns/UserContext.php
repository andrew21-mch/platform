<?php

/**
 * Ushahidi User Context Trait
 *
 * Gives objects methods for setting and retrieving the user context.
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace Ushahidi\Core\Concerns;

use Ushahidi\Contracts\Session;
use Ushahidi\Contracts\Entity as User;

trait UserContext
{
    // storage for the user
    protected $session;

    /**
     * Set the user session
     * @param  Session $session  set the context
     * @return void
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Get the user session
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Get the user context.
     * @return User
     */
    public function getUser()
    {
        if (!$this->session) {
            throw new \RuntimeException('Cannot get the user context before it has been set');
        }

        return $this->session->getUser();
    }

    /**
     * Get the userid for this context.
     * @return Integer
     */
    public function getUserId()
    {
        return $this->getUser()->id;
    }

    /**
     * Checks if currently logged in user is the same as passed entity/array
     * @param  User    $entity entity to check
     * @return boolean
     */
    protected function isUserSelf($entity)
    {
        $entity = is_object($entity) ? $entity->asArray() : $entity;
        return ((int) $entity['id'] === (int) $this->getUserId());
    }
}
