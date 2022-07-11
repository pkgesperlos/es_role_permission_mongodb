<?php

namespace Esperlos98\EsAccess\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maklad\Permission\Models\Role;
use Esperlos98\EsAccess\Repository\Validate\ValidateRequest;
use Esperlos98\EsAccess\Lib\Config\ValidateOptions;

class CreateRoleController extends Controller
{

    const  MASSAGE = "create role";

    public function create(Request $request ,ValidateOptions $validate)
    {
        $validate =  resolve(ValidateRequest::class)->
            validate($request,$validate::VALIDATE["ROLE"],$validate::VALIDATE["MASSAGES"]);

        if($validate){
            return $validate;
        };

        Role::create(['name' => $request->role]);

        return response()->json(self::MASSAGE,200);
    }
}
