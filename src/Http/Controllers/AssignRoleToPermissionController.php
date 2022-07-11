<?php

namespace Esperlos98\EsAccess\Http\Controllers;

use Illuminate\Http\Request;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;
use Esperlos98\EsAccess\Repository\Validate\ValidateRequest;
use Esperlos98\EsAccess\Lib\Config\ValidateOptions;
use phpDocumentor\Reflection\Types\Null_;

class AssignRoleToPermissionController
{
    const MASSAGE = "assign sucssfulled";

    public function assign(Request $request, ValidateOptions $validate)
    {
        $validate =  resolve(ValidateRequest::class)->validate($request, $validate::VALIDATE["ROLE_AND_PERMISSION_ID"], $validate::VALIDATE["MASSAGES"]);

        if ($validate) {
            return $validate;
        };

        $role = Role::find($request->role_id);

        $permissionId = $request->permission_id;

        if ($permissionId == Null) {
            return Null;
        }

        $permission = Permission::find($permissionId);

        if (isset($role) && isset($permission)) {
            $role->givePermissionTo($permission);
        }

        return response()->json(self::MASSAGE, Response::HTTP_OK);
    }
}
