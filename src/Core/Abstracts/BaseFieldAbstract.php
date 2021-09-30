<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;
use Uasoft\Badaso\Module\Graphql\Core\Interfaces\BaseFieldInterface;
use Uasoft\Badaso\Module\Graphql\Core\Parameters\ResolveParameter;

abstract class BaseFieldAbstract implements BaseFieldInterface
{
    public GenerateGraphql $generate_graphql;
    public Request $request;
    public Collection $data_types;
    public array $graphql_data_type;

    public function __construct(GenerateGraphql $generate_graphql)
    {
        $this->generate_graphql = $generate_graphql;
        $this->request = $generate_graphql->request;
        $this->data_types = $generate_graphql->data_types;
        $this->graphql_data_type = $generate_graphql->graphql_data_type;
    }

    protected function next($object_value, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info): ResolveParameter
    {
        return new ResolveParameter($object_value, $args, $context, $info);
    }

    public function middlewareResolveHandle($object_value, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info)
    {

        // to do code..

        return $this->next($object_value, $args, $context, $info);
    }

    public function responseHandle($resolve_result)
    {

        // to do code ..

        return $resolve_result;
    }
}
