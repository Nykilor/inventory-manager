<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create PersonResource
        DB::table('person')->insert([
            'name' => 'Adam',
            'last_name' => 'Migacz',
            'inside_identifier' => '001',
            'phone' => '666999666',
            'email' => 'demo@company.com',
            'is_employed' => true
        ]);

        DB::table('person')->insert([
            'name' => 'Adam',
            'last_name' => 'Adamiak',
            'inside_identifier' => '00',
            'phone' => '666939666',
            'email' => 'demo2@company.com',
            'is_employed' => true
        ]);

        DB::table('person')->insert([
            'name' => 'Jan',
            'last_name' => 'Kowalski',
            'inside_identifier' => '039',
            'phone' => '663092032',
            'email' => 'demo3@company.com',
            'is_employed' => true
        ]);

        //Create User
        DB::table('users')->insert([
            'name' => 'Adam',
            'email' => 'demo@company.com',
            'password' => Hash::make('root'),
            'person_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Adam2',
            'email' => 'demo2@company.com',
            'password' => Hash::make('root'),
            'person_id' => 2
        ]);

        //Create items
        DB::table('item')->insert([
           'serial' => 'DBJFVG3',
           'model' => 'Latitude 5570',
           'producer' => 'Dell',
           'person_id' => 1,
           'inside_identifier' => '00001839'
        ]);

        DB::table('item')->insert([
            'serial' => 'DBKDG3',
            'model' => 'Latitude 5570',
            'producer' => 'Dell',
            'person_id' => 1,
            'inside_identifier' => '00001840'
        ]);

        DB::table('item')->insert([
            'serial' => '129492148jfjskf38',
            'model' => 'Galaxy xCover ',
            'producer' => 'Samsung',
            'person_id' => 1,
            'inside_identifier' => '00001841'
        ]);

        //Create category
        DB::table('category')->insert([
            'name' => 'Laptop'
        ]);

        DB::table('category')->insert([
           'name' => 'Smart phone'
        ]);

        //Create items categories
        DB::table('item_category')->insert([
           'category_id' => 1,
           'item_id' => 1
        ]);

        DB::table('item_category')->insert([
            'category_id' => 1,
            'item_id' => 2
        ]);

        DB::table('item_category')->insert([
            'category_id' => 2,
            'item_id' => 3
        ]);

        //Create categories access
        DB::table('category_access')->insert([
            'write' => true,
            'read' => true,
            'update' => true,
            'users_id' => 1,
            'category_id' => 1
        ]);

        DB::table('category_access')->insert([
            'write' => true,
            'read' => true,
            'update' => true,
            'users_id' => 1,
            'category_id' => 2
        ]);

        DB::table('category_access')->insert([
            'write' => true,
            'read' => true,
            'update' => true,
            'users_id' => 2,
            'category_id' => 2
        ]);

        //Create item person change history entry
        DB::table('item_person_change_history')->insert([
            'item_id' => 2,
            'new_person_id' => 3
        ]);

        DB::table('item_person_change_history')->insert([
            'item_id' => 3,
            'new_person_id' => 3
        ]);

        //POSTMAN token 'uponEWl9argMtcLBkiselShftonPrnYwscaFFHeZ'
        DB::table('personal_access_tokens')->insert([
           'tokenable_type' => 'App\Models\User',
           'tokenable_id' => 1,
            'name' => 'demo',
            'token' => 'fd12edb1f0e84ecdf419501fbdb9dbb44afb03c9f8707f36aa80f3aeebcd53e9',
            'abilities' => '["read","create","update","delete"]'
        ]);
    }
}
