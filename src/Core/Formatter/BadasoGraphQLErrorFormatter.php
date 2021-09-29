<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Formatter;

use GraphQL\Error\ClientAware;
use GraphQL\Error\DebugFlag;
use GraphQL\Error\Error;
use GraphQL\Error\FormattedError;
use GraphQL\Language\SourceLocation;
use GraphQL\Utils\Utils;
use Throwable;
use Uasoft\Badaso\Module\Graphql\Core\Exception\BadasoGraphQLException;

class BadasoGraphQLErrorFormatter extends FormattedError
{

    /** @var string */
    private static $internalErrorMessage = 'Internal server error';

    /**
     * Standard GraphQL error formatter. Converts any exception to array
     * conforming to GraphQL spec.
     *
     * This method only exposes exception message when exception implements ClientAware interface
     * (or when debug flags are passed).
     *
     * For a list of available debug flags @see \GraphQL\Error\DebugFlag constants.
     *
     * @param string $internalErrorMessage
     *
     * @return mixed[]
     *
     * @throws Throwable
     *
     * @api
     */
    public static function createFromException(Throwable $exception, int $debug = DebugFlag::NONE, $internalErrorMessage = null): array
    {

        $internalErrorMessage = $internalErrorMessage ?? self::$internalErrorMessage;

        if ($exception instanceof ClientAware) {

            $formattedError = [
                'message'  => $exception->isClientSafe() ? $exception->getMessage() : $internalErrorMessage,
                'extensions' => [
                    'category' => $exception->getCategory(),
                ],
            ];

            $exception_previous = $exception->getPrevious();
            if ($exception_previous instanceof BadasoGraphQLException) {
                $error_details = $exception_previous->getErrorDetails();
                if (count($error_details) > 0) {
                    $formattedError['details'] = $exception_previous->getErrorDetails();
                }
            }
        } else {
            $formattedError = [
                'message'  => $internalErrorMessage,
                'extensions' => [
                    'category' => Error::CATEGORY_INTERNAL,
                ],
            ];
        }

        if ($exception instanceof Error) {
            $locations = Utils::map(
                $exception->getLocations(),
                static function (SourceLocation $loc): array {
                    return $loc->toSerializableArray();
                }
            );
            if (count($locations) > 0) {
                $formattedError['locations'] = $locations;
            }

            if (count($exception->path ?? []) > 0) {
                $formattedError['path'] = $exception->path;
            }
            if (count($exception->getExtensions() ?? []) > 0) {
                $formattedError['extensions'] = $exception->getExtensions() + $formattedError['extensions'];
            }
        }

        if ($debug !== DebugFlag::NONE) {
            $formattedError = self::addDebugEntries($formattedError, $exception, $debug);
        }

        return $formattedError;
    }
}
