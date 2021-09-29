<?php
namespace Uasoft\Badaso\Module\Graphql\Core\Exception;

use Exception;
use GraphQL\Error\ClientAware;
use Uasoft\Badaso\Module\Graphql\Core\Abstracts\BadasoGraphQLExceptionAbstract;

class BadasoGraphQLException extends Exception implements ClientAware{
    private array $error_details = [];

    public function __construct($message = "", $error_details = [], $category = "internal",  $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->category = $category;
        $this->error_details = $error_details;
    }

    public function getErrorDetails(){
        return $this->error_details ;
    }

    public function isClientSafe(){
        return true ;
    }

    public function getCategory(){
        return 'internal' ;
    }

}
