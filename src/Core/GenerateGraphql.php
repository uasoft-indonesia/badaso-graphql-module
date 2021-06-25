<?php

namespace Uasoft\Badaso\Module\Graphql\Core;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Uasoft\Badaso\Helpers\CaseConvert;
use Uasoft\Badaso\Models\DataType;

class GenerateGraphql
{
    public static $createInputType = 'CreateInputType';
    public static $updateInputType = 'UpdateInputType';
    public static $deleteInputType = 'DeleteInputType';
    public static $browseType = 'Browse';
    public static $readType = 'Read';
    public static $queryType = 'Query';
    public static $mutationType = 'Mutation';
    public $accommodate;
    public $accommodateBadasoGraphQL;
    public $data_types;
    public $graphql_data_type;

    public function __construct()
    {
        $this->data_types = DataType::all();
        $this->graphql_data_type = [];

        // AccommodateClassRegister
        $this->accommodate = config('badaso-graphql.accommodate_badaso_graphql_class');
        $this->accommodateBadasoGraphQL = new $this->accommodate();

        // Custom Type
        foreach ($this->accommodateBadasoGraphQL->registerType() as $index => $registerType) {
            $type_class = new $registerType();
            $type_class->setGenerateGraphQL($this);
            $this->graphql_data_type = array_merge($this->graphql_data_type, $type_class->getType());
        }

        // Custom Type From Core
        foreach (scandir(__DIR__ . "/Type") as $index => $registerType) {
            if ($index >= 2) {
                $name_class = "Uasoft\\Badaso\\Module\\Graphql\\Core\\Type\\" . str_replace('.php', '', $registerType);
                $type_class = new $name_class();
                $type_class->setGenerateGraphQL($this);
                $this->graphql_data_type = array_merge($this->graphql_data_type, $type_class->getType());
            }
        }
    }

    private function saveToGraphQLDataType($table_name, $key, $value)
    {
        $this->graphql_data_type[$table_name][$key] = $value;
    }

    public function setToGraphQLDataType($table_name, $type_name, $object_type)
    {
        if (!array_key_exists($table_name, $this->graphql_data_type)) {
            $this->graphql_data_type[$table_name] = [];
        }

        if (!array_key_exists($type_name, $this->graphql_data_type[$table_name])) {
            $this->saveToGraphQLDataType($table_name, $type_name, $object_type);
        }
    }

    private function generateQueryAndMutation(): void
    {
        $data_types = $this->data_types;
        $fields_query = [];
        $fields_mutations = [];
        foreach ($data_types as $index => $data_type) {
            $generate_query_graphql = config('badaso-graphql.class.generate_query_graphql');
            $fields_query = (new $generate_query_graphql($this->graphql_data_type, $data_type, $fields_query))->handle();

            $generate_mutation_graphql = config('badaso-graphql.class.generate_mutation_graphql');
            $fields_mutations = (new $generate_mutation_graphql($this->graphql_data_type, $data_type, $fields_mutations))->handle();
        }

        // Custom Query
        foreach ($this->accommodateBadasoGraphQL->registerQuery() as $index => $registerQuery) {
            $query_type_class = new $registerQuery();
            $query_type_class->setGenerateGraphQL($this, $fields_query);
            $fields_query = array_merge($fields_query, $query_type_class->getFieldQuery());
        }

        // Custom Query From Core
        foreach (scandir(__DIR__ . "/Query") as $index => $registerType) {
            if ($index >= 2) {
                $name_class = "Uasoft\\Badaso\\Module\\Graphql\\Core\\Query\\" . str_replace('.php', '', $registerType);
                $query_type_class = new $name_class();
                $query_type_class->setGenerateGraphQL($this, $fields_query);
                $fields_query = array_merge($fields_query, $query_type_class->getFieldQuery());
            }
        }

        // Query
        $name_query = self::$queryType;
        $object_query = new ObjectType([
            'name' => $name_query,
            'fields' => $fields_query,
        ]);
        $this->graphql_data_type[$name_query] = $object_query;

        // Custom Mutation
        foreach ($this->accommodateBadasoGraphQL->registerMutation() as $index => $registerMutation) {
            $mutation_type_class = new $registerMutation();
            $mutation_type_class->setGenerateGraphQL($this, $fields_mutations);
            $fields_mutations = array_merge($fields_mutations, $mutation_type_class->getFieldMutation());
        }

        // Custom Mutation From Core
        foreach (scandir(__DIR__ . "/Mutation") as $index => $registerType) {
            if ($index >= 2) {
                $name_class = "Uasoft\\Badaso\\Module\\Graphql\\Core\\Mutation\\" . str_replace('.php', '', $registerType);
                $mutation_type_class = new $name_class();
                $mutation_type_class->setGenerateGraphQL($this, $fields_mutations);
                $fields_mutations = array_merge($fields_mutations, $mutation_type_class->getFieldMutation());
            }
        }

        // Mutation
        $name_mutation = self::$mutationType;
        $object_mutation = new ObjectType([
            'name' => $name_mutation,
            'fields' => $fields_mutations,
        ]);
        $this->graphql_data_type[$name_mutation] = $object_mutation;
    }

    private function generateRelationModelType($field_name_types, $fields, $type_name)
    {
        $relation_field_name_types = $field_name_types->filter(function ($data_row) {
            return $data_row->relation != null && $data_row->type == 'relation';
        });

        if ($relation_field_name_types->count() >= 1) {
            foreach ($relation_field_name_types as $index => $data_row) {
                $relation_detail = [];
                try {
                    $relation_detail = is_string($data_row->relation) ? json_decode($data_row->relation) : $data_row->relation;
                    $relation_detail = CaseConvert::snake($relation_detail);
                } catch (\Exception $e) {
                }

                $relation_type = array_key_exists('relation_type', $relation_detail) ? $relation_detail['relation_type'] : null;
                $destination_table = array_key_exists('destination_table', $relation_detail) ? $relation_detail['destination_table'] : null;
                $destination_table_column = array_key_exists('destination_table_column', $relation_detail) ? $relation_detail['destination_table_column'] : null;
                $destination_table_display_column = array_key_exists('destination_table_display_column', $relation_detail) ? $relation_detail['destination_table_display_column'] : null;

                if (
                    $relation_type
                    && $destination_table
                    && $destination_table_column
                    && $destination_table_display_column
                ) {
                    if (!array_key_exists($destination_table, $this->graphql_data_type)) {
                        // get data type (table data)
                        $data_type = $this->data_types->where('name', $destination_table);

                        if ($data_type->count() == 0) {
                            // tables not extends to data types
                            $data_row_relation = collect(Schema::getColumnListing($destination_table))->map(function ($field) {
                                return (object) [
                                    'browse' => 1,
                                    'read' => 1,
                                    'field' => $field,
                                    'required' => 1,
                                ];
                            });

                            $array_type = $this->generateModelArrayType(
                                $destination_table,
                                $data_row_relation,
                                self::$browseType
                            );
                        } else {
                            $data_row_relation = $data_type->dataRows;
                            $array_type = $this->generateModelArrayType(
                                $destination_table,
                                $data_row_relation,
                                self::$browseType
                            );
                        }

                        $object_type = new ObjectType($array_type['array_type']);
                        $this->setToGraphQLDataType($destination_table, self::$browseType, $object_type);
                    }

                    $field_data_row = $data_row->field;
                    $graphql_data_type = $this->graphql_data_type[$destination_table];
                    switch ($relation_type) {
                        case 'belongs_to':
                            $fields[$destination_table] = [
                                'type' => $graphql_data_type[self::$browseType],
                                'resolve' => function ($rootValue, $args) use ($destination_table, $destination_table_column, $field_data_row) {
                                    $relation_value = $rootValue->{$field_data_row};
                                    $result = DB::table($destination_table)->where($destination_table_column, $relation_value)->first();

                                    return $result;
                                },
                            ];
                            break;

                        case 'has_one':
                            // replace this
                            $fields[$destination_table] = [
                                'type' => $graphql_data_type[self::$browseType],
                                'resolve' => function ($rootValue, $args) use ($destination_table, $destination_table_column, $field_data_row) {
                                    $relation_value = $rootValue->{$field_data_row};
                                    $result = DB::table($destination_table)->where($destination_table_column, $relation_value)->first();

                                    return $result;
                                },
                            ];
                            break;

                        case 'has_many':
                            // replace this
                            $fields[$destination_table] = [
                                'type' => $graphql_data_type[self::$browseType],
                                'resolve' => function ($rootValue, $args) use ($destination_table, $destination_table_column, $field_data_row) {
                                    $relation_value = $rootValue->{$field_data_row};
                                    $result = DB::table($destination_table)->where($destination_table_column, $relation_value)->get();

                                    return $result;
                                },
                            ];
                            break;
                    }
                }
            }
        }

        return $fields;
    }

    private function generateModelArrayType($table_name, $data_rows, $type_name)
    {
        $name_type = ucwords(CaseConvert::camel($table_name . $type_name));
        $field_name_types = $data_rows->filter(function ($data_row) use ($type_name) {
            switch ($type_name) {
                case self::$browseType:
                    return $data_row->browse;
                case self::$readType:
                    return $data_row->read;
            }
        });

        $fields = [];
        foreach ($field_name_types as $index => $data_row) {
            $field = $data_row->field;
            $required = $data_row->required;

            $type = $required ? Type::nonNull(Type::string()) : Type::string();
            if ($field == 'id') {
                $type = $required ? Type::nonNull(Type::id()) : Type::id();
            }

            $fields[$field] = [
                'type' => $type,
            ];
        }

        $object_type = [
            'name' => $name_type,
            'fields' => $fields,
        ];

        return [
            'array_type' => $object_type,
            'field_name_types' => $field_name_types,
        ];
    }

    private function generateModelType($table_name, $data_rows, $type_name): void
    {
        [
            'array_type' => $array_type,
            'field_name_types' => $field_name_types,
        ] = $this->generateModelArrayType($table_name, $data_rows, $type_name);

        // get relation field
        $array_type['fields'] = $this->generateRelationModelType($field_name_types, $array_type['fields'], $type_name);

        // save object to graphql
        $object_type = new ObjectType($array_type);
        $this->setToGraphQLDataType($table_name, $type_name, $object_type);
    }

    private function generateInputType($table_name, $data_rows, $input_type_name): void
    {
        $name_create_input_type = ucwords(CaseConvert::camel($table_name . $input_type_name));
        $field_create_input_type = $data_rows->filter(function ($data_row) use ($input_type_name) {
            switch ($input_type_name) {
                case 'CreateInputType':
                    return $data_row->add;
                case 'UpdateInputType':
                    return $data_row->edit;
                case 'DeleteInputType':
                    return $data_row->delete;
            }
        });

        $fields = [];
        foreach ($field_create_input_type as $index => $data_row) {
            $field = $data_row->field;
            $required = $data_row->required;

            $type = $required ? Type::nonNull(Type::string()) : Type::string();
            if ($field == 'id') {
                $type = $required ? Type::nonNull(Type::id()) : Type::id();
            }

            $fields[$field] = [
                'type' => $type,
            ];
        }

        $object_type_create_input_type = new InputObjectType([
            'name' => $name_create_input_type,
            'fields' => $fields,
        ]);

        $this->saveToGraphQLDataType($table_name, $input_type_name, $object_type_create_input_type);
    }

    private function generateType(DataType $data_type)
    {
        $table_name = $data_type->name;
        $data_rows = $data_type->dataRows;
        foreach ([self::$createInputType, self::$updateInputType, self::$deleteInputType] as $index => $input_type_name) {
            $this->generateInputType($table_name, $data_rows, $input_type_name);
        }

        foreach ([self::$browseType, self::$readType] as $key => $input_type_name) {
            $this->generateModelType($table_name, $data_rows, $input_type_name);
        }
    }

    public function handle()
    {
        foreach ($this->data_types as $index => $data_type) {
            $this->generateType($data_type);
        }
        $this->generateQueryAndMutation();
    }
}
