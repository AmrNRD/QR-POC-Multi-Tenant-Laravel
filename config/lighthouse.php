<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Controls the HTTP route that your GraphQL server responds to.
    | You may set `route` => false, to disable the default route
    | registration and take full control.
    |
    */

    'route' => [
        /*
         * The URI the endpoint responds to, e.g. mydomain.com/graphql.
         */
        'uri' => '/graphql',

        /*
         * Lighthouse creates a named route for convenient URL generation and redirects.
         */
        'name' => 'graphql',

        /*
         * Beware that middleware defined here runs before the GraphQL execution phase,
         * make sure to return spec-compliant responses in case an error is thrown.
         */
        'middleware' => [
            \Nuwave\Lighthouse\Support\Http\Middleware\AcceptJson::class,

            // Logs in a user if they are authenticated. In contrast to Laravel's 'auth'
            // middleware, this delegates auth and permission checks to the field level.
            // If you want to use another guard, change the suffix (remove for default).
            \Nuwave\Lighthouse\Support\Http\Middleware\AttemptAuthentication::class.':api',
        ],

        /*
         * The `prefix` and `domain` configuration options are optional.
         */
        //'prefix' => '',
        //'domain' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema Location
    |--------------------------------------------------------------------------
    |
    | This is a path that points to where your GraphQL schema is located
    | relative to the app path. You should define your entire GraphQL
    | schema in this file (additional files may be imported).
    |
    */

    'schema' => [
        'register' => base_path('graphql/schema.graphql')
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema Cache
    |--------------------------------------------------------------------------
    |
    | A large part of schema generation consists of parsing and AST manipulation.
    | This operation is very expensive, so it is highly recommended to enable
    | caching of the final schema to optimize performance of large schemas.
    |
    */

    'cache' => [
        'enable' => env('LIGHTHOUSE_CACHE_ENABLE', env('APP_ENV') !== 'local'),
        'key' => env('LIGHTHOUSE_CACHE_KEY', 'lighthouse-schema'),
        'ttl' => env('LIGHTHOUSE_CACHE_TTL', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces
    |--------------------------------------------------------------------------
    |
    | These are the default namespaces where Lighthouse looks for classes to
    | extend functionality of the schema. You may pass in either a string
    | or an array, they are tried in order and the first match is used.
    |
    */

    'namespaces' => [
        'models' => [
            '\App\Domain\User\Entities',
		'\App\Domain\Dashboard\Entities',
		'\App\Domain\Attendance\Entities',
		'\App\Domain\Attendance\Entities',
		'\App\Domain\Shift\Entities',
		'\App\Domain\Tenant\Employee\Entities',
		'\App\Domain\Shift\Entities',
		'\App\Domain\Admin\Entities',
		'\App\Domain\Subscription\Entities',
		'\App\Domain\Company\Entities',
		###DOMAIN\ENTITY###
        ],
        'queries' => [
            '\App\Domain\User\Graphql\Queries',
		'\App\Domain\Dashboard\Graphql\Queries',
		'\App\Domain\Attendance\Graphql\Queries',
		'\App\Domain\Attendance\Graphql\Queries',
		'\App\Domain\Shift\Graphql\Queries',
		'\App\Domain\Tenant\Employee\Graphql\Queries',
		'\App\Domain\Shift\Graphql\Queries',
		'\App\Domain\Admin\Graphql\Queries',
		'\App\Domain\Subscription\Graphql\Queries',
		'\App\Domain\Company\Graphql\Queries',
		###DOMAIN\QUERY###
        ],
        'mutations' => [
            '\App\Domain\User\Graphql\Mutations',
		'\App\Domain\Dashboard\Graphql\Mutations',
		'\App\Domain\Attendance\Graphql\Mutations',
		'\App\Domain\Attendance\Graphql\Mutations',
		'\App\Domain\Shift\Graphql\Mutations',
		'\App\Domain\Tenant\Employee\Graphql\Mutations',
		'\App\Domain\Shift\Graphql\Mutations',
		'\App\Domain\Admin\Graphql\Mutations',
		'\App\Domain\Subscription\Graphql\Mutations',
		'\App\Domain\Company\Graphql\Mutations',
		###DOMAIN\MUTATION###
        ],
        'subscriptions' => [
            '\App\Domain\User\Graphql\Subscriptions',
		'\App\Domain\Dashboard\Graphql\Subscriptions',
		'\App\Domain\Attendance\Graphql\Subscriptions',
		'\App\Domain\Attendance\Graphql\Subscriptions',
		'\App\Domain\Shift\Graphql\Subscriptions',
		'\App\Domain\Tenant\Employee\Graphql\Subscriptions',
		'\App\Domain\Shift\Graphql\Subscriptions',
		'\App\Domain\Admin\Graphql\Subscriptions',
		'\App\Domain\Subscription\Graphql\Subscriptions',
		'\App\Domain\Company\Graphql\Subscriptions',
		###DOMAIN\SUBSCRIPTION###
        ],
        'interfaces' => [
            '\App\Domain\User\Graphql\Interfaces',
		'\App\Domain\Dashboard\Graphql\Interfaces',
		'\App\Domain\Attendance\Graphql\Interfaces',
		'\App\Domain\Attendance\Graphql\Interfaces',
		'\App\Domain\Shift\Graphql\Interfaces',
		'\App\Domain\Tenant\Employee\Graphql\Interfaces',
		'\App\Domain\Shift\Graphql\Interfaces',
		'\App\Domain\Admin\Graphql\Interfaces',
		'\App\Domain\Subscription\Graphql\Interfaces',
		'\App\Domain\Company\Graphql\Interfaces',
		###DOMAIN\INTERFACE###
        ],
        'unions' => [
            '\App\Domain\User\Graphql\Unions',
		'\App\Domain\Dashboard\Graphql\Unions',
		'\App\Domain\Attendance\Graphql\Unions',
		'\App\Domain\Attendance\Graphql\Unions',
		'\App\Domain\Shift\Graphql\Unions',
		'\App\Domain\Tenant\Employee\Graphql\Unions',
		'\App\Domain\Shift\Graphql\Unions',
		'\App\Domain\Admin\Graphql\Unions',
		'\App\Domain\Subscription\Graphql\Unions',
		'\App\Domain\Company\Graphql\Unions',
		###DOMAIN\UNION###
        ],
        'scalars' => [
            '\App\Domain\User\Graphql\Scalars',
		'\App\Domain\Dashboard\Graphql\Scalars',
		'\App\Domain\Attendance\Graphql\Scalars',
		'\App\Domain\Attendance\Graphql\Scalars',
		'\App\Domain\Shift\Graphql\Scalars',
		'\App\Domain\Tenant\Employee\Graphql\Scalars',
		'\App\Domain\Shift\Graphql\Scalars',
		'\App\Domain\Admin\Graphql\Scalars',
		'\App\Domain\Subscription\Graphql\Scalars',
		'\App\Domain\Company\Graphql\Scalars',
		###DOMAIN\SCALAR###
        ],
        'directives' => [
            '\App\Domain\User\Graphql\Directives',
		'\App\Domain\Dashboard\Graphql\Directives',
		'\App\Domain\Attendance\Graphql\Directives',
		'\App\Domain\Attendance\Graphql\Directives',
		'\App\Domain\Shift\Graphql\Directives',
		'\App\Domain\Tenant\Employee\Graphql\Directives',
		'\App\Domain\Shift\Graphql\Directives',
		'\App\Domain\Admin\Graphql\Directives',
		'\App\Domain\Subscription\Graphql\Directives',
		'\App\Domain\Company\Graphql\Directives',
		###DOMAIN\DIRECTIVE###
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    |
    | Control how Lighthouse handles security related query validation.
    | Read more at http://webonyx.github.io/graphql-php/security/
    |
    */

    'security' => [
        'max_query_complexity' => \GraphQL\Validator\Rules\QueryComplexity::DISABLED,
        'max_query_depth' => \GraphQL\Validator\Rules\QueryDepth::DISABLED,
        'disable_introspection' => \GraphQL\Validator\Rules\DisableIntrospection::DISABLED,
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Limits the maximum "count" that users may pass as an argument
    | to fields that are paginated with the @paginate directive.
    | A setting of "null" means the count is unrestricted.
    |
    */

    'paginate_max_count' => null,

    /*
    |--------------------------------------------------------------------------
    | Pagination Amount Argument
    |--------------------------------------------------------------------------
    |
    | Set the name to use for the generated argument on paginated fields
    | that controls how many results are returned.
    |
    | DEPRECATED This setting will be removed in v5.
    |
    */

    'pagination_amount_argument' => 'first',

    /*
    |--------------------------------------------------------------------------
    | @orderBy input name
    |--------------------------------------------------------------------------
    |
    | Set the name to use for the generated argument on the
    | OrderByClause used for the @orderBy directive.
    |
    | DEPRECATED This setting will be removed in v5.
    |
    */

    'orderBy' => 'field',

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    |
    | Control the debug level as described in http://webonyx.github.io/graphql-php/error-handling/
    | Debugging is only applied if the global Laravel debug config is set to true.
    |
    */

    'debug' => \GraphQL\Error\Debug::INCLUDE_DEBUG_MESSAGE | \GraphQL\Error\Debug::INCLUDE_TRACE,

    /*
    |--------------------------------------------------------------------------
    | Error Handlers
    |--------------------------------------------------------------------------
    |
    | Register error handlers that receive the Errors that occur during execution
    | and handle them. You may use this to log, filter or format the errors.
    | The classes must implement \Nuwave\Lighthouse\Execution\ErrorHandler
    |
    */

    'error_handlers' => [
        \Nuwave\Lighthouse\Execution\ExtensionErrorHandler::class,
        \Nuwave\Lighthouse\Execution\ReportingErrorHandler::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Global ID
    |--------------------------------------------------------------------------
    |
    | The name that is used for the global id field on the Node interface.
    | When creating a Relay compliant server, this must be named "id".
    |
    */

    'global_id_field' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Batched Queries
    |--------------------------------------------------------------------------
    |
    | GraphQL query batching means sending multiple queries to the server in one request,
    | You may set this flag to either process or deny batched queries.
    |
    */

    'batched_queries' => true,

    /*
    |--------------------------------------------------------------------------
    | Transactional Mutations
    |--------------------------------------------------------------------------
    |
    | If set to true, mutations such as @create or @update will be
    | wrapped in a transaction to ensure atomicity.
    |
    */

    'transactional_mutations' => true,

    /*
    |--------------------------------------------------------------------------
    | Batchload Relations
    |--------------------------------------------------------------------------
    |
    | If set to true, relations marked with directives like @hasMany or @belongsTo
    | will be optimized by combining the queries through the BatchLoader.
    |
    */

    'batchload_relations' => true,

    /*
    |--------------------------------------------------------------------------
    | GraphQL Subscriptions
    |--------------------------------------------------------------------------
    |
    | Here you can define GraphQL subscription "broadcasters" and "storage" drivers
    | as well their required configuration options.
    |
    */

    'subscriptions' => [
        /*
         * Determines if broadcasts should be queued by default.
         */
        'queue_broadcasts' => env('LIGHTHOUSE_QUEUE_BROADCASTS', true),

        /*
         * Determines the queue to use for broadcasting queue jobs.
         */
        'broadcasts_queue_name' => env('LIGHTHOUSE_BROADCASTS_QUEUE_NAME', null),

        /*
         * Default subscription storage.
         *
         * Any Laravel supported cache driver options are available here.
         */
        'storage' => env('LIGHTHOUSE_SUBSCRIPTION_STORAGE', 'redis'),

        /*
         * Default subscription storage time to live in seconds.
         *
         * Indicates how long a subscription can be active before it's automatically removed from storage.
         * Setting this to `null` means the subscriptions are stored forever. This may cause
         * stale subscriptions to linger indefinitely in case cleanup fails for any reason.
         */
        'storage_ttl' => env('LIGHTHOUSE_SUBSCRIPTION_STORAGE_TTL', null),

        /*
         * Default subscription broadcaster.
         */
        'broadcaster' => env('LIGHTHOUSE_BROADCASTER', 'pusher'),

        /*
         * Subscription broadcasting drivers with config options.
         */
        'broadcasters' => [
            'log' => [
                'driver' => 'log',
            ],
            'pusher' => [
                'driver' => 'pusher',
                'routes' => \Nuwave\Lighthouse\Subscriptions\SubscriptionRouter::class.'@pusher',
                'connection' => 'pusher',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Defer
    |--------------------------------------------------------------------------
    |
    | Configuration for the experimental @defer directive support.
    |
    */

    'defer' => [
        /*
         * Maximum number of nested fields that can be deferred in one query.
         * Once reached, remaining fields will be resolved synchronously.
         * 0 means unlimited.
         */
        'max_nested_fields' => 0,

        /*
         * Maximum execution time for deferred queries in milliseconds.
         * Once reached, remaining fields will be resolved synchronously.
         * 0 means unlimited.
         */
        'max_execution_ms' => 0,
    ],

];
