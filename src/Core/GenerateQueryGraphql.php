<?php

namespace Uasoft\Badaso\Module\Graphql\Core;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Helpers\CaseConvert;
use Uasoft\Badaso\Module\Graphql\Traits\PermissionForCRUDTrait;

class GenerateQueryGraphql extends \Uasoft\Badaso\Controllers\Controller
{
    use PermissionForCRUDTrait;

    protected $fields_query;
    protected $data_type;
    protected $graphql_data_type;
    protected $table_name;
    protected $create_input_type;
    protected $update_input_type;
    protected $delete_input_type;
    protected $read_type;
    protected $browse_type;

    public function __construct($generate_graphql, $data_type, $fields_query)
    {
        $this->generate_graphql = $generate_graphql ;
        $this->graphql_data_type = $generate_graphql->graphql_data_type;
        $this->data_type = $data_type;
        $this->fields_query = $fields_query;
        $this->table_name = $this->data_type->name;
        $this->graphql_data_type = $this->graphql_data_type[$this->table_name];

        [
            GenerateGraphql::$CREATE_INPUT_TYPE => $this->create_input_type,
            GenerateGraphql::$UPDATE_INPUT_TYPE => $this->update_input_type,
            GenerateGraphql::$DELETE_INPUT_TYPE => $this->delete_input_type,
            GenerateGraphql::$READ_TYPE => $this->read_type,
            GenerateGraphql::$BROWSE_TYPE => $this->browse_type,
        ] = $this->graphql_data_type;

        $this->customizeFieldQuery();
    }

    protected function customizeFieldQuery()
    {
        // todo customize fields query
    }

    public function generateFindQuery()
    {
        // @find with id
        $this->fields_query[CaseConvert::camel($this->table_name . '_find')] = [
            'type' => $this->read_type,
            'args' => [
                'id' => Type::nonNull(Type::id()),
            ],
            'resolve' => function ($rootValue, $args) {
                $this->permissionCrud('read');

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
                    $this->permissionCrud('browse');

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
