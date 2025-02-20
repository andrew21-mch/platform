<?php

/**
 * Form Permissions
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace Ushahidi\Core\Tools\Permissions;

use Ushahidi\Core\Entity\User;
use Ushahidi\Contracts\Permission;
use Ushahidi\Core\Concerns\Acl as AccessControlList;
use Ushahidi\Core\Concerns\AdminAccess;

class FormPermissions
{
    use AccessControlList;
    use AdminAccess;

    /**
     * Does the user have permission to edit the form?
     *
     * @param  User   $user
     * @param  Int    $form_id
     * @return Boolean
     */
    public function canUserEditForm(User $user, $form_id)
    {
        // @todo delegate to form authorizer
        return $this->acl->hasPermission($user, Permission::MANAGE_POSTS);
    }
}
