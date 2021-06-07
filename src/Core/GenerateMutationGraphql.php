<?php

namespace Uasoft\Badaso\Module\Graphql\Core;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;

class GenerateMutationGraphql
{
    private $graphql_data_type;
    private $data_type;
    private $fields_mutations;
    private $create_input_type;
    private $update_input_type;
    private $delete_input_type;
    private $read_type;
    private $browse_type;

    public function __construct($graphql_data_type, $data_type, $fields_mutations)
    {
        $this->graphql_data_type = $graphql_data_type;
        $this->data_type = $data_type;
        $this->fields_mutations = $fields_mutations;
        $this->table_name = $this->data_type->name;

        $this->graphql_data_type = $this->graphql_data_type[$this->table_name];
        [
            GenerateTypeGraphql::$createInputType => $this->create_input_type,
            GenerateTypeGraphql::$updateInputType => $this->update_input_type,
            GenerateTypeGraphql::$deleteInputType => $this->delete_input_type,
            GenerateTypeGraphql::$readType => $this->read_type,
            GenerateTypeGraphql::$browseType => $this->browse_type,
        ] = $this->graphql_data_type;
    }

    public function generateCrudMutation()
    {
        // generate create
        $this->fields_mutations[$this->table_name.'_create'] = [
            'type' => $this->read_type,
            'args' => [
                'input' => $this->create_input_type,
            ],
            'resolve' => function ($rootValue, $args) {
                $data_create = $args['input'];
                DB::table($this->table_name)->insert([$data_create]);
                $table_latest_after_create = DB::table($this->table_name)->latest('id')->first();

                return $table_latest_after_create;
            },
        ];
    }

    public function generateUpdateMutation()
    {
        // generate update
        $this->fields_mutations[$this->table_name.'_update'] = [
            'type' => $this->read_type,
            'args' => [
                'id' => Type::string(),
                'input' => $this->update_input_type,
            ],
            'resolve' => function ($rootValue, $args) {
                $data_update = $args['input'];
                $table_update = DB::table($this->table_name)->where('id', $args['id']);

                $table_update->update($data_update);

                return $table_update->first();
            },
        ];
    }

    public function generateDeleteMutation()
    {
        // generate delete
        $this->fields_mutations[$this->table_name.'_delete'] = [
            'type' => Type::string(),
            'args' => [
                'id' => Type::string(),
            ],
            'resolve' => function ($rootValue, $args) {
                $data_delete = DB::table($this->table_name);

                return $data_delete->delete($args['id']) ? 'Delete Success' : 'Failed Delete';
            },
        ];
    }

    public function handle()
    {
        $this->generateCrudMutation();
        $this->generateUpdateMutation();
        $this->generateDeleteMutation();

        return $this->fields_mutations;
    }
}
