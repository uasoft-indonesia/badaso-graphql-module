<?php

namespace Uasoft\Badaso\Module\Graphql\Controllers;

use Exception;
use GraphQL\Error\DebugFlag;
use GraphQL\Error\Error;
use GraphQL\Error\FormattedError;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use Illuminate\Http\Request;
use Uasoft\Badaso\Module\Graphql\Core\Formatter\BadasoGraphQLErrorFormatter;

class BadasoGraphqlController extends Controller
{
    public function graphql(Request $request)
    {
        $class_generate_graphql = config('badaso-graphql-customize.core.generate_graphql');

        $graphql_generate = new $class_generate_graphql($request);
        $graphql_generate->handle();
        $graphql_generate_data_type = $graphql_generate->graphql_data_type;

        $schema = new Schema([
            'query' => $graphql_generate_data_type['Query'],
            'mutation' => $graphql_generate_data_type['Mutation'],
        ]);

        $query = $request->get('query');
        $variableValues = isset($request->variables) ? $request->variables : null;
        $rootValue = isset($request->root) ? $request->root : null;
        $context = isset($request->context) ? $request->context : null;


        $result = GraphQL::executeQuery(
            $schema,
            $query,
            $rootValue,
            $context,
            $variableValues,
        )
            ->setErrorFormatter(function (Error $e) {
                $formatterError = BadasoGraphQLErrorFormatter::createFromException($e);
                return $formatterError;
            })
            ->setErrorsHandler(function (array $errors, callable $formatter) {
                return array_map($formatter, $errors);
            })->toArray();

        return response()->json($result);
    }
}
