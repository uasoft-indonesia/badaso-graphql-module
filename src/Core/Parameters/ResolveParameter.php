<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Parameters;

class ResolveParameter
{
    public $object_value;
    public $args;
    public $context;
    public \GraphQL\Type\Definition\ResolveInfo $info;

    public function __construct($object_value, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info)
    {
        $this->object_value = $object_value;
        $this->args = $args;
        $this->context = $context;
        $this->info = $info;
    }
}
