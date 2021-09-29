<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;
use Uasoft\Badaso\Module\Graphql\Core\Interfaces\BaseFieldInterface;

abstract class BaseFieldAbstract implements BaseFieldInterface {

    public GenerateGraphql $generate_graphql ;
    public Request $request;
    public Collection $data_types;
    public array $graphql_data_type;

    public function __construct(GenerateGraphql $generate_graphql){
        $this->generate_graphql = $generate_graphql ;
        $this->request = $generate_graphql->request ;
        $this->data_types = $generate_graphql->data_types ;
        $this->graphql_data_type = $generate_graphql->graphql_data_type ;
    }


}
