<?php

namespace Esperlos98\EsAccess\Lib\Config;

class ValidateOptions
{
    const VALIDATE = [
        "ROLE" => [
            "role" => "required|unique:mongodb.roles,name",    
        ],
        "PERMISSION" => [
            "permission" => "required|unique:mongodb.permissions,name",    
        ],
        "ROLE_AND_PERMISSION_ID" => [
            "role_id" =>  "required|string",
            "permission_id" => "required",
        ],
        "ROLE_AND_USER_ID" => [
            "user_id" =>  "required|string",
            "role_id" => "required",
        ],
        "SYNC_ROLE_AND_USER" => [
            "user_id" =>  "required|string",
            "role_id" => "required",
        ],
        "SYNC_PERMISSION_AND_ROLE" => [
            "role_id" =>  "required|string",
            "permission_id" => "required",
        ],

        "MASSAGES" => [
            "required" =>  601,
            "unique"=> 605
        ],
        "TOKEN_FOR_TEST" => [
            "token" => "OTptTGbqxxoRge516AvXbH4sWK2gb6YVAScQU1K7QKHbmcG8yop36y5pOImuak2OC7sLo3J1rHkzyNZpsiLRIlEQfvURvzJ7uwKomccxamfIW1VPRQOIGclyxrYKWGIwojX41rryTnfeumunwvEx63ys6M3MQNN4bg6FgMylrIRTBU0koYPijJTq15hhNxXkoEUaODOdrrIjHiguUb5uyYRT9EYtySPlykIPePfrNmf2Ggla0y425AHpfX"
        ]
    ];
}

