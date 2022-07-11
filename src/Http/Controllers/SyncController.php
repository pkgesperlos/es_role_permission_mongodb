<?php

namespace Esperlos98\EsAccess\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Maklad\Permission\Models\Role;
use Esperlos98\EsAccess\Repository\Validate\ValidateRequest;
use Esperlos98\EsAccess\Lib\Config\ValidateOptions;
use Maklad\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class SyncController
{
    const  MASSAGE = "sync sucssfulled";

    public function role(Request $request, ValidateOptions $validate)
    {

        $validate =  resolve(ValidateRequest::class)->validate($request, $validate::VALIDATE["SYNC_ROLE_AND_USER"], $validate::VALIDATE["MASSAGES"]);

        if ($validate) {
            return $validate;
        };

        $user = User::find($request->user_id);
        $listRolesUser = $user->role_ids;
        if ($user) {
            $user->syncRoles();
        }

        $roleId = $request->role_id;
        $roles = $this->filter($listRolesUser,$roleId);
        if ($roleId == Null) {
            return Null;
        }

        foreach ($roles as $roleId) {

            $role = Role::find($roleId);

            if (isset($user) && isset($role)) {
                $user->assignRole($role);
            }
        }

        return response()->json(self::MASSAGE, Response::HTTP_OK);
    }

    public function permission(Request $request, ValidateOptions $validate)
    {
        $validate =  resolve(ValidateRequest::class)->validate($request, $validate::VALIDATE["SYNC_PERMISSION_AND_ROLE"], $validate::VALIDATE["MASSAGES"]);

        if ($validate) {
            return $validate;
        };

        $role = Role::find($request->role_id);
        $listRolePermissions = $role->permission_ids;
        if ($role) {
            $role->syncPermissions();
        }

        $PermissionId = $request->permission_id;
        $permissions = $this->filter($listRolePermissions, $PermissionId);

        foreach ($permissions as $permissionId) {

            $permission = Permission::find($permissionId);

            if (isset($role) && isset($permission)) {
                $role->givePermissionTo($permission);
            }
        }

        return response()->json(self::MASSAGE, Response::HTTP_OK);
    }

    public function filter($list, $key): array
    {
        return array_diff($list, (array) $key);
    }
}
