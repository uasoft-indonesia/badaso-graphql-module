<?php

namespace App\BadasoGraphQL;

use App\BadasoGraphQL\Mutation\ExampleMutation;
use App\BadasoGraphQL\Query\ExampleQuery;
use App\BadasoGraphQL\Type\ExampleType;
use Uasoft\Badaso\Module\Graphql\Interfaces\AccommodateHandleInterface;

class AccommodateBadasoGraphQL implements AccommodateHandleInterface
{
    public function registerType(): array
    {
        return [
            ExampleType::class,
        ];
    }

    public function registerQuery(): array
    {
        return [
            ExampleQuery::class,
        ];
    }

    public function registerMutation(): array
    {
        return [
            ExampleMutation::class,
        ];
    }
}
