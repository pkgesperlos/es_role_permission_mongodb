<?php

namespace Esperlos98\EsAccess\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Maklad\Permission\Models\Role;
use Esperlos98\EsAccess\Repository\Validate\ValidateRequest;
use Esperlos98\EsAccess\Lib\Config\ValidateOptions;
use Symfony\Component\HttpFoundation\Response;

class SyncController
{
    const  MASSAGE = "sync sucssfulled";

    public function role(Request $request, ValidateOptions $validate)
    {

        $validate =  resolve(ValidateRequest::class)->
            validate($request, $validate::VALIDATE["SYNC_ROLE_AND_USER"], $validate::VALIDATE["MASSAGES"]);

        if ($validate) {
            return $validate;
        };

        $user = User::find($request->user_id);
        if($user){
            $user->syncRoles();
        }

        $jsonRoleIds = $request->role_ids;
        $roleIds  = json_decode($jsonRoleIds, true);

        if($roleIds == Null){
            return Null;
        }

        foreach ($roleIds["ids"] as $roleId) {

            $role = Role::find($roleId);

            if (isset($user) && isset($role)) {
                $user->assignRole($role);
            }
        }

        return response()->json(self::MASSAGE,Response::HTTP_OK);
    }

    public function permission(Request $request , ValidateOptions $validate)
    {
        $validate =  resolve(ValidateRequest::class)->
            validate($request, $validate::VALIDATE["SYNC_PERMISSION_AND_USER"], $validate::VALIDATE["MASSAGES"]);

        if ($validate) {
            return $validate;
        };

        $user = User::find($request->user_id);
        if($user){
            $user->syncPermissions();
        }

        $jsonPermissionIds = $request->permission_ids;
        $permissionIds  = json_decode($jsonPermissionIds, true);
        if($permissionIds == Null){
            return Null;
        }

        foreach ($permissionIds["ids"] as $permissionId) {

            $role = Role::find($permissionId);

            if (isset($user) && isset($permission)) {
                $user->assignPermission($permission);
            }
        }

        return response()->json(self::MASSAGE,Response::HTTP_OK);
    }
}

