<?php

namespace Uasoft\Badaso\Module\Graphql\Interfaces;

use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;

interface GenerateTypeInterface
{
    public function setGenerateGraphQL(GenerateGraphql $generate_graphql): void;

    public function getType(): array;
}
