<?php

namespace Uasoft\Badaso\Module\Graphql\Interfaces;

interface AccommodateHandleInterface
{
    public function registerType(): array;

    public function registerQuery(): array;

    public function registerMutation(): array;
}
