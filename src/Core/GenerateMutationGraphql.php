<?php

namespace Uasoft\Badaso\Module\Graphql\Core;

use GraphQL\Error\UserError;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Module\Graphql\Traits\PermissionForCRUDTrait;

class GenerateMutationGraphql extends \Uasoft\Badaso\Controllers\Controller
{
    use PermissionForCRUDTrait;

    protected $graphql_data_type;
    protected $data_type;
    protected $fields_mutations;
    protected $create_input_type;
    protected $update_input_type;
    protected $delete_input_type;
    protected $read_type;
    protected $browse_type;

    public function __construct($graphql_data_type, $data_type, $fields_mutations)
    {
        $this->graphql_data_type = $graphql_data_type;
        $this->data_type = $data_type;
        $this->fields_mutations = $fields_mutations;
        $this->table_name = $this->data_type->name;

        $this->graphql_data_type = $this->graphql_data_type[$this->table_name];
        [
            GenerateGraphql::$createInputType => $this->create_input_type,
            GenerateGraphql::$updateInputType => $this->update_input_type,
            GenerateGraphql::$deleteInputType => $this->delete_input_type,
            GenerateGraphql::$readType => $this->read_type,
            GenerateGraphql::$browseType => $this->browse_type,
        ] = $this->graphql_data_type;

        $this->customizeFieldMutation();
    }

    protected function customizeFieldMutation()
    {
        // todo customize fields mutation
    }

    public function generateCreateMutation()
    {
        // generate create
        $this->fields_mutations[$this->table_name.'_create'] = [
            'type' => $this->read_type,
            'args' => [
                'input' => $this->create_input_type,
            ],
            'resolve' => function ($rootValue, $args) {
                $this->permissionCrud('add');

                DB::beginTransaction();
                try {
                    $data_create = $args['input'];
                    $stored_data = $this->insertData($data_create, $this->data_type);

                    activity($this->data_type->display_name_singular)
                    ->causedBy(auth()->user() ?? null)
                    ->withProperties(['attributes' => $stored_data])
                    ->log($this->data_type->display_name_singular.' has been created');

                    DB::commit();

                    return $stored_data;
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw new UserError($e->getMessage());
                }
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
                $this->permissionCrud('edit');

                DB::beginTransaction();
                try {
                    $data_update_id = $args['id'];
                    $data_update = $args['input'];
                    $data_update['id'] = $data_update_id;

                    $updated = $this->updateData($data_update, $this->data_type)['updated_data'];

                    activity($this->data_type->display_name_singular)
                    ->causedBy(auth()->user() ?? null)
                    ->withProperties([
                        'old' => $updated['old_data'],
                        'attributes' => $updated['updated_data'],
                    ])
                    ->log($this->data_type->display_name_singular.' has been updated');

                    DB::commit();

                    return $updated;
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw new UserError($e->getMessage());
                }
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
                $this->permissionCrud('delete');

                DB::beginTransaction();
                try {
                    $this->deleteData($args, $this->data_type);

                    activity($this->data_type->display_name_singular)
                    ->causedBy(auth()->user() ?? null)
                    ->withProperties($args)
                    ->log($this->data_type->display_name_singular.' has been deleted');

                    DB::commit();

                    return 'Delete Success';
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw new UserError($e->getMessage());
                }
            },
        ];
    }

    public function handle()
    {
        $this->generateCreateMutation();
        $this->generateUpdateMutation();
        $this->generateDeleteMutation();

        return $this->fields_mutations;
    }
}
