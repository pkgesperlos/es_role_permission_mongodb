<?php

namespace Esperlos98\EsAccess\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Esperlos98\EsAccess\Repository\Validate\ValidateRequest;
use Esperlos98\EsAccess\Lib\Config\ValidateOptions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maklad\Permission\Models\Role;

class AssignRoleToUserController extends Controller
{
    const MASSAGE = "assign sucssfulled";

    public function assign(Request $request, ValidateOptions $validate)
    {
        $validate =  resolve(ValidateRequest::class)->
            validate($request,$validate::VALIDATE["ROLE_AND_USER_ID"],$validate::VALIDATE["MASSAGES"]);

        if($validate){
            return $validate;
        };

        $user = User::find($request->user_id);
        $roleId  = $request->role_id;

        if($roleId == Null){
            return Null;
        }

         $role = Role::find($roleId);

         if (isset($user) && isset($role)) {
         	$user->assignRole($role);
         }

        return response()->json(self::MASSAGE,Response::HTTP_OK);

    }
}
