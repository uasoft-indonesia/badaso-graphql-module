<?php

namespace Uasoft\Badaso\Module\Graphql\Traits;

use GraphQL\Error\UserError;
use Uasoft\Badaso\Helpers\AuthenticatedUser;

trait PermissionForCRUDTrait
{
    public function permissionCrud($action)
    {
        $data_type = $this->data_type;
        $continue = AuthenticatedUser::ignore($action.'_'.$data_type->name);
        if (! $continue) {
            $continue = AuthenticatedUser::isAllowedTo($action.'_'.$data_type->name);
            if (! $continue) {
                throw new UserError();
            }
        }
    }
}
