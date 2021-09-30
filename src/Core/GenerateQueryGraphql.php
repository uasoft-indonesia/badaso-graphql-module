<?php

namespace Uasoft\Badaso\Module\Graphql\Core;

use Doctrine\DBAL\Types\ObjectType;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Helpers\CaseConvert;
use Uasoft\Badaso\Module\Graphql\Core\Type\PaginateType;
use Uasoft\Badaso\Module\Graphql\Core\Type\ResultAllDataType;
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
        $this->generate_graphql = $generate_graphql;
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

    public function generateSearchQuery(){
        // @search text
        $this->fields_query[CaseConvert::camel($this->table_name . '_search')] = [
            'type' => new PaginateType($this->browse_type, 'search_'.$this->table_name),
            'args' => [
                'q' => [
                    'type' => Type::string(),
                ],
                'bys' => [
                    'type' => Type::listOf(Type::string()),
                    'defaultValue' => ['*'],
                    'description' => "
                        search by * for all field in table, your can add only one field\n
                        example : ['name_file1', 'name_field2', ..., 'name_fieldN']
                    "
                ],
                'page' => [
                    'type' => Type::int(),
                    'defaultValue' => 1,
                ],
                'maxDataPerPage' => [
                    'type' => Type::int(),
                    'defaultValue' => 15,
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                $this->permissionCrud('read');

                ['q' => $q, 'bys' => $bys, 'page' => $page, 'maxDataPerPage' => $max_data_per_page] = $args ;

                $query = DB::table($this->table_name) ;

                foreach ($bys as $key => $by) {
                    if ($by == '*') {
                        foreach ($this->browse_type->getFields() as $key => $field) {
                            $field_name = $field->name;
                            $query = $query->orWhere($field_name, "like", "%{$q}%");
                        }
                    } else {
                        $query = $query->orWhere($by, "like", "%{$q}%");
                    }
                }

                $query = $query->offset(ceil(abs($page - 1) * $max_data_per_page))->limit($max_data_per_page) ;

                $data = $query->get();
                $max_data = $query->count();
                $max_page = ceil($max_data/$max_data_per_page) ;

                return PaginateType::result($data, $max_data, $max_page) ;
            },
        ];
    }

    public function generateAllQuery()
    {
        // @all
        if ($this->data_type->server_side) {
            $this->fields_query[$this->table_name] = function () {
                return [
                    'type' => new PaginateType($this->browse_type, $this->table_name),
                    'args' => [
                        'page' => [
                            'type' => Type::int(),
                            'defaultValue' => 1,
                        ],
                        'maxDataPerPage' => [
                            'type' => Type::int(),
                            'defaultValue' => 15,
                        ]
                    ],
                    'resolve' => function ($rootValue, $args) {
                        $this->permissionCrud('browse');

                        ['page' => $page, 'maxDataPerPage' => $max_data_per_page] = $args ;

                        $query = DB::table($this->table_name)->offset(ceil(abs($page - 1) * $max_data_per_page))->limit($max_data_per_page) ;

                        $max_data = $query->count();
                        $data = $query->get();
                        $max_page = ceil($max_data/$max_data_per_page) ;

                        return PaginateType::result($data, $max_data, $max_page);
                    },
                ];
            };
        } else {
            $this->fields_query[$this->table_name] = function () {
                return [
                    'type' => new ResultAllDataType($this->browse_type, $this->table_name),
                    'resolve' => function ($rootValue, $args) {
                        $this->permissionCrud('browse');

                        $query = DB::table($this->table_name) ;
                        $data = $query->get();

                        $max_data = $data->count() ;
                        return ResultAllDataType::result($data, $max_data);
                    },
                ];
            };
        }


    }

    public function handle()
    {
        $this->generateAllQuery();
        $this->generateFindQuery();
        $this->generateSearchQuery();

        // add customize
        $this->customizeFieldQuery();

        return $this->fields_query;
    }
}
