<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $data=[
            ['link_name'=>"何大大",
            'link_title'=>"seeder测试啊",
            'link_url'=>"http://www.ni1.cc",
            'link_order'=>1
            ],
            ['link_name'=>"王二君啊",
            'link_title'=>"seeder测试啊",
            'link_url'=>"http://www.qe28.com",
            'link_order'=>2
            ],
            ['link_name'=>"小婊砸",
            'link_title'=>"seeder测试啊",
            'link_url'=>"http://www.spsoso.com",
            'link_order'=>3
            ],
            ['link_name'=>"何大大",
            'link_title'=>"seeder测试啊",
            'link_url'=>"http://www.ni1.cc",
            'link_order'=>4
            ],

        ];

        DB::table('links')->insert($data);
    }
}
