<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelperTest;

class BadasoGraphqlTest extends TestCase
{

    public function test_example()
    {
        $token = CallHelperTest::login($this);
        Schema::create('table_test_graphql', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('old');
            $table->string('address');
            $table->timestamps();
        });
        
        $data =   [
                    "name" => "table_test_graphql",
                    "slug" => "table-test-graphql",
                    "displayNameSingular" => "Table Test Graphql",
                    "displayNamePlural" => "Table Test Graphql",
                    "icon" => "",
                    "modelName" => "",
                    "policyName" => "",
                    "description" => "",
                    "generatePermissions" => true,
                    "createSoftDelete" => false,
                    "serverSide" => false,
                    "details" => "",
                    "controller" => "",
                    "orderColumn" => "",
                    "orderDisplayColumn" => "",
                    "orderDirection" => "",
                    "notification" => [],
                    "rows" => [
                        [
                            "field" => "id",
                            "type" => "number",
                            "displayName" => "Id",
                            "required" => true,
                            "browse" => true,
                            "read" => true,
                            "edit" => false,
                            "add" => false,
                            "delete" => false,
                            "details" => "{}",
                            "order" => 1,
                            "setRelation" => false,
                        ],
                        [
                            "field" => "name",
                            "type" => "text",
                            "displayName" => "Name",
                            "required" => true,
                            "browse" => true,
                            "read" => true,
                            "edit" => true,
                            "add" => true,
                            "delete" => true,
                            "details" => "{}",
                            "order" => 1,
                            "setRelation" => false,
                        ],
                        [
                            "field" => "old",
                            "type" => "number",
                            "displayName" => "Old",
                            "required" => true,
                            "browse" => true,
                            "read" => true,
                            "edit" => true,
                            "add" => true,
                            "delete" => true,
                            "details" => "{}",
                            "order" => 1,
                            "setRelation" => false,
                        ],
                        [
                            "field" => "address",
                            "type" => "text",
                            "displayName" => "Address",
                            "required" => true,
                            "browse" => true,
                            "read" => true,
                            "edit" => true,
                            "add" => true,
                            "delete" => true,
                            "details" => "{}",
                            "order" => 1,
                            "setRelation" => false,
                        ],
                        [
                            "field" => "created_at",
                            "type" => "datetime",
                            "displayName" => "Created At",
                            "required" => false,
                            "browse" => true,
                            "read" => true,
                            "edit" => false,
                            "add" => false,
                            "delete" => false,
                            "details" => "{}",
                            "order" => 1,
                            "setRelation" => false,
                        ],
                        [
                            "field" => "updated_at",
                            "type" => "datetime",
                            "displayName" => "Updated At",
                            "required" => false,
                            "browse" => true,
                            "read" => true,
                            "edit" => false,
                            "add" => false,
                            "delete" => false,
                            "details" => "{}",
                            "order" => 1,
                            "setRelation" => false,
                        ],
                    ],
                ];

            $response = $this->withHeader('Authorization', "Bearer $token")->json("POST", CallHelperTest::getUrlApiV1Prefix('/crud/add'), $data);
            $response->assertSuccessful();
    }

    public function test_add_data_graphql(){
        $token = CallHelperTest::login($this);
            $data_same = [
                    "data" => 
                        [
                            "name" => "asdasd", 
                            "old" => "123", 
                            "address" => "lkasjdlajskd"
                            ]
                     ];

            $GPL = <<<GPL
                mutation{
                    tableTestGraphqlCreate(input: {name:"asdasd", old:"123", address:"lkasjdlajskd" })
                    {
                        name, 
                        old, 
                        address
                     }
                }
            GPL;

            $data = [
                "query" => $GPL
            ];

       
        $response = $this->withHeader("Authorization", "Bearer $token")->json("POST", env("APP_URL").('/badaso/graphql/v1'), $data);
        $response->assertSuccessful();

        $response_data = $response->json('data');

        $this->assertTrue($response_data['tableTestGraphqlCreate']['name'] == $data_same['data']['name']);
        $this->assertTrue($response_data['tableTestGraphqlCreate']['old'] == $data_same['data']['old']);
        $this->assertTrue($response_data['tableTestGraphqlCreate']['address'] == $data_same['data']['address']);
    }

    public function test_update_data_graphql(){
        $token = CallHelperTest::login($this);
        $table = DB::table('table_test_graphql')->latest()->first();
        $data_same = [
                    "data" => 
                        [
                            "name" => "name", 
                            "old" => "21", 
                            "address" => "lmjnhgj"
                            ]
                     ];
        $GPL = <<<GPL
                mutation{
                    tableTestGraphqlUpdate(id:"$table->id" input: 
                    {name:"name", old:"21", address:"lmjnhgj" }){
                        name, old, address
                }
                }
            GPL;
        $data = [
            "query" => $GPL
        ];   
        $response = $this->withHeader("Authorization", "Bearer $token")->json("POST", env("APP_URL").('/badaso/graphql/v1'), $data);
        $response->assertSuccessful();
        
        
        $response_data = $response->json('data');

        
        $this->assertTrue($response_data['tableTestGraphqlUpdate']['name'] == $data_same['data']['name']);
        $this->assertTrue($response_data['tableTestGraphqlUpdate']['old'] == $data_same['data']['old']);
        $this->assertTrue($response_data['tableTestGraphqlUpdate']['address'] == $data_same['data']['address']);
    }

   

    public function test_read_all_data_graphql(){
        $token = CallHelperTest::login($this);
        $table = DB::table('table_test_graphql')->get();
        $GPL = <<<GPL
                {
                    table_test_graphql{
                    data{
                        id
                        name
                        old
                        address
                    }
                    maxData
                }
                }
        GPL;

        $data = [
            "query" => $GPL
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")->json("POST", env('APP_URL')."/badaso/graphql/v1", $data);
        $response->assertSuccessful();
        $data = $response->json('data.table_test_graphql.data');
      
        foreach ($data as $key => $value) {
            $table = DB::table('table_test_graphql')->find($value['id']);
            $this->assertTrue($value['name'] == $table->name);
            $this->assertTrue($value['old'] == $table->old);
            $this->assertTrue($value['address'] == $table->address);
        }

    }

    public function test_find_data_graphql(){
        $token = CallHelperTest::login($this);
         $table = DB::table('table_test_graphql')->latest()->first();
        $GPL = <<<GPL
                query{
                    tableTestGraphqlFind(id:"$table->id"){
                id
                        name
                    old
                    address
                }
                }
        GPL;
        
        $data = [
            "query" => $GPL
        ];
        
         $response = $this->withHeader('Authorization', "Bearer $token")->json("POST", env('APP_URL')."/badaso/graphql/v1", $data);
         
         $response->assertSuccessful();   
         $data =$response->json('data.tableTestGraphqlFind');

         $table = DB::table('table_test_graphql')->find($data['id']);

         $this->assertTrue($data['name'] == $table->name);
         
    }

    public function test_search_data_graphql(){
        $token = CallHelperTest::login($this);
        $table = DB::table('table_test_graphql')->latest()->first();
        $GPL = <<<GPL
            query{
                tableTestGraphqlSearch(q:"asd", bys:["*"],page:1, maxDataPerPage:5){
                    data{
                        id
                        name
                        old
                        address
                    }
                    maxData
                    maxPage
                }
            }
        GPL;
        
        $data = [
            "query" => $GPL,
        ];
       
         $response = $this->withHeader('Authorization', "Bearer $token")->json("POST", env('APP_URL')."/badaso/graphql/v1", $data);

         $response->assertSuccessful();   
         $data =$response->json('data.tableTestGraphqlSearch.data');
         foreach ($data as $key => $value) {
            $table = DB::table('table_test_graphql')->find($value['id']);
            $this->assertTrue($value['name'] == $table->name);
            $this->assertTrue($value['old'] == $table->old);
            $this->assertTrue($value['address'] == $table->address);
        }
    }



     public function test_delete_data_graphql(){
        $token = CallHelperTest::login($this);
        $table = DB::table('table_test_graphql')->latest()->first();
        $GPL = <<<GPL
                mutation{
                    tableTestGraphqlDelete(id:"$table->id")
                }
        GPL;
        $data = [
            "query" => $GPL
        ];

        $response = $this->withHeader("Authorization", "Bearer $token")->json("POST", env("APP_URL").('/badaso/graphql/v1'), $data);
        $response->assertSuccessful();

        $response->assertStatus(200);        
       
    }
    
    public function test_delete_table_graphql(){
        $token = CallHelperTest::login($this);
    
        $data_delete = DB::table('badaso_data_types')->where('name', 'table_test_graphql')->get();
        $data = [
            "id" => $data_delete[0]->id
        ];
        $response = $this->withHeader("Authorization", "Bearer $token")->json("DELETE", CallHelperTest::getUrlApiV1Prefix('/crud/delete'), $data);
        $response->assertSuccessful();
        Schema::drop('table_test_graphql');
    }
}
