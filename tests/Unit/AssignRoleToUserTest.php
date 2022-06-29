<?php

namespace Esperlos98\Esauthentication\tests\Unit;

use Tests\TestCase;
use Esperlos98\EsAccess\Lib\Config\ValidateOptions;
use Illuminate\Support\Str;

class AssignRoleToUserTest extends TestCase
{

    public function test_assign_successful(){
      
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . ValidateOptions::VALIDATE["TOKEN_FOR_TEST"]["token"],
        ])->json("post", env('APP_URL') . "/es/api/v1/assignRoleToUser", [
            "user_id" => Str::random("30"),
            "role_ids" => '{"ids":[""]}',
        ]);

        return $this->assertTrue($response->status() == 200);
    }
    
    public function test_assign_defeat(){

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . ValidateOptions::VALIDATE["TOKEN_FOR_TEST"]["token"],
            ])->json("post", env('APP_URL') . "/es/api/v1/assignRoleToUser", [
            "user_id" => Str::random("30"),
            "role_ids" => '',
        ]);
        
        
        return $this->assertTrue($response->status() == 400);
    }
}

?>