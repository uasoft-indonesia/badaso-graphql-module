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

                // handle before process
                $this->base_field_interface->middlewareResolveHandle($objectValue, $args, $context, $info);

                // handle process
                $resolve = $this->base_field_interface->resolve($objectValue, $args, $context, $info);

                // handle after process
                return $this->base_field_interface->responseHandle($resolve);
            },
        ];

        if ($this->base_field_interface->getArgs() != null && count($this->base_field_interface->getArgs()) > 0) {
            $output['args'] = $this->base_field_interface->getArgs();
        }

        return $output;
    }
}
