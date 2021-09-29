<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Interfaces;


use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;

interface BaseFieldInterface
{
    public function __construct(GenerateGraphql $generate_graphql);
    public function getName(): string;
    public function getType();
    public function getArgs(): array;
    public function resolve($objectValue, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info);
    public function middlewareResolveHandle($objectValue, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info) : void ;
    public function responseHandle($resolve_result);
}
