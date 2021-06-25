<?php

namespace Uasoft\Badaso\Module\Graphql\Controllers;

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use Illuminate\Http\Request;
use Uasoft\Badaso\Helpers\ApiResponse;

class BadasoGraphqlController extends Controller
{
    public function graphql(Request $request)
    {
        try {
            $class_generate_graphql = config('badaso-graphql.class.generate_graphql');

            $graphql_generate = new $class_generate_graphql();
            $graphql_generate->handle();
            $graphql_generate_data_type = $graphql_generate->graphql_data_type;

            $schema = new Schema([
                'query' => $graphql_generate_data_type['Query'],
                'mutation' => $graphql_generate_data_type['Mutation'],
            ]);

            $query = $request->get('query');
            $variableValues = isset($request->variables) ? $request->variables : null;
            $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);
            $output = $result->toArray();

            return response()->json($output);
        } catch (\Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
