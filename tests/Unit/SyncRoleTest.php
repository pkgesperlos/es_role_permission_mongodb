<?php

namespace Esperlos98\Esauthentication\tests\Unit;

use Tests\TestCase;
use Esperlos98\EsAccess\Lib\Config\ValidateOptions;
use Illuminate\Support\Str;

class SyncRoleTest extends TestCase
{


    public function test_sync_defeat(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . ValidateOptions::VALIDATE["TOKEN_FOR_TEST"]["token"],
        ])->json("post", env('APP_URL') . "/es/api/v1/syncRole", [
            "user_id" => Str::random("30"),
            "permission_ids" => '',
        ]);
            
        return $this->assertTrue($response->status() == 400);
    }
}

?>