<?php

namespace Esperlos98\Esauthentication\tests\Unit;

use Tests\TestCase;
use Esperlos98\EsAccess\Lib\Config\ValidateOptions;

use Illuminate\Support\Str;

class CreatePermissonTest extends TestCase
{

    public function test_create_successful(){
        
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.ValidateOptions::VALIDATE["TOKEN_FOR_TEST"]["token"],
            ])->json("post",env('APP_URL')."/es/api/v1/createPermission",[
                "permission"=> Str::random("30")
            ]);
        
        return $this->assertTrue($response->status() == 200);
    }

    public function test_create_defeat(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.'',
        ])->json("post",env('APP_URL')."/es/api/v1/createPermission",[
            "role"=> Str::random("30")
        ]);
        
        return $this->assertTrue($response->status() == 401);
    }
}

?>