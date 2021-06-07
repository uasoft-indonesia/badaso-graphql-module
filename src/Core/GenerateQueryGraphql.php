<?php

namespace Uasoft\Badaso\Module\Graphql\Core;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;

class GenerateQueryGraphql
{
    private $fields_query;
    private $data_type;
    private $graphql_data_type;
    private $table_name;
    private $create_input_type;
    private $update_input_type;
    private $delete_input_type;
    private $read_type;
    private $browse_type;

    public function __construct($graphql_data_type, $data_type, $fields_query)
    {
        $this->graphql_data_type = $graphql_data_type;
        $this->data_type = $data_type;
        $this->fields_query = $fields_query;
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

    public function generateFindQuery()
    {
        // @find with id
        $this->fields_query[$this->table_name.'_find'] = [
            'type' => $this->read_type,
            'args' => [
                'id' => Type::nonNull(Type::id()),
            ],
            'resolve' => function ($rootValue, $args) {
                return DB::table($this->table_name)->find($args['id']);
            },
        ];
    }

    public function generateAllQuery()
    {
        // @all
        $this->fields_query[$this->table_name] = function () {
            return [
                'type' => Type::listOf($this->browse_type),
                'resolve' => function ($rootValue, $args) {
                    return DB::table($this->table_name)->get();
                },
            ];
        };
    }

    public function handle()
    {
        $this->generateAllQuery();
        $this->generateFindQuery();

        return $this->fields_query;
    }
}
