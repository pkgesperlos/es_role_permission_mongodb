<?php

namespace Esperlos98\EsAccess\Console;

use Illuminate\Console\Command;
use Maklad\Permission\Models\Role;
use App\Models\User;

class CreateAdmin extends Command
{
    protected $signature = 'userAdmin:install {id} {permission=user edit} {role=admin}';

    protected $description = 'assign user to admin and user edit';

    public function handle()
    {
        $role = Role::findByName($this->argument("role"));
        $role->givePermissionTo($this->argument("permission"));

        $user = User::find($this->argument("id"));

        $user->assignRole($this->argument("role"));

        echo "successfull assign user \n";
    }

}
