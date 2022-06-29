<?php

namespace Esperlos98\EsAccess\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maklad\Permission\Models\Role;
use Esperlos98\EsAccess\Repository\Validate\ValidateRequest;
use Esperlos98\EsAccess\Lib\Config\ValidateOptions;
use Maklad\Permission\Models\Permission;

class CreatePermissionController extends Controller
{

    const  MASSAGE = "create permission";

    public function create(Request $request ,ValidateOptions $validate)
    {
        $validate =  resolve(ValidateRequest::class)->
            validate($request,$validate::VALIDATE["PERMISSION"],$validate::VALIDATE["MASSAGES"]);

        if($validate){
            return $validate;
        };

        Permission::create(['name' => (string) $request->permission]);

        return response()->json(self::MASSAGE,200);
    }
}
