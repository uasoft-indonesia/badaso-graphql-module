<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Field;

use Uasoft\Badaso\Helpers\CaseConvert;
use Uasoft\Badaso\Module\Graphql\Core\Parameters\ResolveParameter;

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
        $output = [
            'type' => $this->base_field_interface->getType(),
            'resolve' => function ($object_value, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info) {

                // handle before process
                $middleware_resolve = $this->base_field_interface->middlewareResolveHandle($object_value, $args, $context, $info);

                if (! ($middleware_resolve instanceof ResolveParameter)) {
                    return $middleware_resolve;
                }

                // result and replace parameter resolve
                $object_value = $middleware_resolve->object_value;
                $args = $middleware_resolve->args;
                $context = $middleware_resolve->context;
                $info = $middleware_resolve->info;

                // handle process
                $resolve = $this->base_field_interface->resolve($object_value, $args, $context, $info);

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
