<?php

namespace Uasoft\Badaso\Module\Graphql\Interfaces;

use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;

interface GenerateMutationInterface
{
    public function setGenerateGraphQL(GenerateGraphql $generate_graphql, array $field_mutation): void;

    public function getFieldMutation(): array;
}
