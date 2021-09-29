<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Field;

use Uasoft\Badaso\Helpers\CaseConvert;

class BaseField
{

    protected $base_field_interface;


    public function __construct($base_field_interface)
    {
        $this->base_field_interface = $base_field_interface;
    }

    public function getNameCamelCaseFormat()
    {
        return CaseConvert::camel($this->base_field_interface->getName());
    }

    public function toType()
    {
        $output =  [
            'type' => $this->base_field_interface->getType(),
            'resolve' => function ($objectValue, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info) {

                $resolve = $this->base_field_interface->resolve($objectValue, $args, $context, $info);

                return $resolve ;
            },
        ];

        if ($this->base_field_interface->getArgs() != null && count($this->base_field_interface->getArgs()) > 0) {
            $output['args'] = $this->base_field_interface->getArgs();
        }

        return $output;
    }
}