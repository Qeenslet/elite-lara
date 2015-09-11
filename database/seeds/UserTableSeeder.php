<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder {
    public function run(){

        DB::table('planets_values')->truncate();
        DB::table('stars_values')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_user')->truncate();

        DB::table('planets_values')->insert([['planet'=>0, 'value'=>5,'modifier'=>1],
            ['planet'=>1, 'value'=>5,'modifier'=>1],
            ['planet'=>2, 'value'=>2,'modifier'=>1],
            ['planet'=>3, 'value'=>30,'modifier'=>1],
            ['planet'=>4, 'value'=>2,'modifier'=>1],
            ['planet'=>5, 'value'=>5,'modifier'=>1],]);
        DB::table('stars_values')->insert([['star'=>0, 'value'=>0,'modifier'=>1],
            ['star'=>1, 'value'=>0,'modifier'=>1],
            ['star'=>2, 'value'=>0,'modifier'=>1],
            ['star'=>3, 'value'=>0,'modifier'=>1],
            ['star'=>4, 'value'=>0,'modifier'=>1],
            ['star'=>5, 'value'=>0,'modifier'=>1],
            ['star'=>6, 'value'=>3,'modifier'=>1],
            ['star'=>7, 'value'=>2,'modifier'=>1],
            ['star'=>8, 'value'=>3,'modifier'=>1],
            ['star'=>9, 'value'=>0,'modifier'=>1],
            ['star'=>10, 'value'=>0,'modifier'=>1],
            ['star'=>11, 'value'=>0,'modifier'=>1],
            ['star'=>12, 'value'=>0,'modifier'=>1],
            ['star'=>13, 'value'=>0,'modifier'=>1],
            ['star'=>14, 'value'=>8,'modifier'=>1],
            ['star'=>15, 'value'=>5,'modifier'=>1],
            ['star'=>16, 'value'=>7,'modifier'=>1],
            ['star'=>17, 'value'=>5,'modifier'=>1],
            ['star'=>18, 'value'=>5,'modifier'=>1],]);
        DB::table('users')->insert(['name'=>'Elite Base',
                                    'email'=>'cspook@rambler.ru',
                                    'password'=>bcrypt('123456789'),
                                    'created_at'=>\Carbon\Carbon::now(),
                                    'updated_at'=>\Carbon\Carbon::now(),
                                    'confirmed'=>'confirmacion ha pasado']);
        DB::table('roles')->insert([['name'=>'user', 'title'=>'CMDR'],
                                    ['name'=>'admin', 'title'=>'Lord Commander'],
                                    ['name'=>'moderator', 'title'=>'Dark Lord']]);
        DB::table('role_user')->insert([['user_id'=>1, 'role_id'=>3],
                                        ['user_id'=>1, 'role_id'=>2],
                                        ['user_id'=>1, 'role_id'=>1],]);
        DB::table('locales')->insert([['lang'=>'ru'],
            ['lang'=>'en'],]);

    }
}