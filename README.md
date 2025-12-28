<div align="center">
    <h1>MCP PHP Boilerplate</h1>
    <p>PHP Boilerplate Powered by <b>MCP PHP SDK</b></p>

[![php-version-shield]][php-version-link]
[![phpstan-shield]][phpstan-link]
[![][github-release-shield]][github-release-link]

[![status-shield]][status-link]
[![last-commit-shield]][last-commit-link]
[![][github-release-date-shield]][github-release-date-link]
[![github-license-shield]][github-license-link]

</div>

## Project Overview

This template is designed for the development of AI-agent platforms utilizing the [MCP (Model Context
Protocol)](https://modelcontextprotocol.io/) standard
and the [MCP PHP SDK](https://github.com/modelcontextprotocol/php-sdk).
The project incorporates tools for building scalable PHP applications capable of exposing Tools, Resources, and Prompts
to LLM-based agents.

## Core Components

- **Container**: [PHP-DI](https://php-di.org/)
- **PSR-7**: [nyholm/psr7](https://github.com/Nyholm/psr7)
- **Logger**: [Monolog](https://seldaek.github.io/monolog/)
- **Testing**: [PHPUnit](https://phpunit.de/)
- **Static Analysis**: [PHPStan](https://phpstan.org/)

## Getting Started

### Installation

#### Via Composer

Create a new project using Composer:

```bash
composer create-project anvilm/mcp-php-boilerplate my-project
```

#### Via GitHub

Clone the repository and install dependencies:

```bash
git clone https://github.com/anvilm/mcp-php-boilerplate.git my-project
cd my-project
composer install
```

### Running the Application

#### HTTP Mode (e.g. with built-in php server)

```bash
php -S 127.0.0.1:8080 entrypoint/http.php
```

#### Stdio Mode (direct communication via stdin/stdout)

```bash
php entrypoint/stdio.php
```

### Directory Structure

```
.
├── app/                          # Core application logic and infrastructure
│   ├── Bootstrappers/            # Classes for initializing application components
│   ├── Config/                   # Configuration files
│   ├── Tools/                    # MCP Tools definitions
│   ├── Resources/                # MCP resources definitions
│   ├── Prompts/                  # MCP prompts definitions
│   ├── Platform/                 # Core abstractions and handlers
│   ├── Registry/                 # Registration of all available prompts/tools/resources and providers
│   ├── Providers/                # Dependency injection container providers
│   │   ├── ApplicationProviders/ # Providers for application functionality
│   │   └── Providers/            # Custom providers
│   └── Kernel.php                # Application entry point and bootstrap management
├── entrypoint/
│   ├── http.php                  # HTTP entry point
│   └── stdio.php                 # Stdio (stdin/stdout) entry point
├── logs/                         # Application logs
├── src/                          # Source code for custom logic
└── tests/                        # PHPUnit tests
```

### Directory Organization

The boilerplate is structured to separate infrastructural logic from user-defined code:

- **Directory `app/`**: Contains the core infrastructure of the application,
  including [configurations](#configuration), [providers](#providers), [tools](#tools-resources-prompts), [resources](#tools-resources-prompts),
  and [bootstrappers](#bootstrappers). This directory is intended for foundational application setup and operation.
- **Directory `src/`**: Designated for user-defined source code, where developers can implement the primary business
  logic of the application.

### Configuration

Application configurations are organized in the `app/Config/` directory and provide type-safe access to settings via
classes with static methods. For further details, refer to the [Configuration](#configuration-1) section.

#### Environment Variables

Environment variables are managed using the [oscarotero/env](https://github.com/oscarotero/env) library. These variables
are read directly from the system, not from a `.env` file, and are intended for use within configuration classes.

Predefined environment variables:

- **APP_ENV**: Defines the application environment (e.g., `production`, `development`), affecting logging levels.
- **APP_DEBUG**: Enables or disables debug mode, influencing the display of detailed error information.
- **APP_NAME**: Name of the application.
- **APP_DESCRIPTION**: Short description of the application.

#### Application Configuration

The `ApplicationConfig` class provides the following parameters:

- **baseDir**: The root directory of the project.
- **appEnv**: The application environment, determined by the `APP_ENV` variable. Available environments are listed in
  the `ApplicationEnvironmentEnum` enumeration. To add a new environment, update this enumeration and the
  `ApplicationConfig` class.
- **appDebug**: Debug mode, determined by the `APP_DEBUG` variable.
- **appName**: Application name, determined by the `APP_NAME` variable.
- **appDescription**: Application description, determined by the `APP_DESCRIPTION` variable.

#### Logging Configuration

The `LoggerConfig` class configures logging parameters using Monolog. It includes the path to log files (in the `logs/`
directory) and the logging level, which depends on the `appEnv` value.

## Architectural Concepts

### Configuration

Configurations are stored in the `app/Config/` directory. Each configuration is implemented as a class with static
methods, ensuring type-safe access to settings.

Example:

```php
namespace Application\Config\ApplicationConfig;

use function Env\env;

final readonly class ApplicationConfig
{
    public static function baseDir(): string
    {
        return dirname(__DIR__, 3);
    }
}
```

### Tools

Tools are defined in the `app/Tools/` directory. Each tool class must extend the abstract class `AbstractTool` and be
[registered](#tools-1) in the `app/Registry/Tools.php` file.

#### Required Implementation Elements

Every tool must define the following properties:

- **Tool Name**: `protected string $name`
- **Input Parameters Schema**: `protected array $inputSchema`

#### Optional Elements

The following properties may be defined to provide additional information:

- **Description**: `protected ?string $description`

- **Icons**: `protected ?array $icons`

- **Metadata**: `protected ?array $meta`

- **Tool Annotations**: To specify tool annotations , the `protected getAnnotations()` method can be overridden. It
  should return an instance
  of `Mcp\Schema\ToolAnnotations` or `null` if no annotations are needed.

Example of creating a tool:

```php
namespace App\Tools;

final class ExampleTool extends AbstractTool
{
    protected string $name = 'example_tool';

    protected ?string $description = "Example tool that returns 'Hello {name}!'.";

    protected array $inputSchema = [
        'type' => 'object',
        'properties' => [
            'name' => ['type' => 'string']
        ],
        'required' => ['name']
    ];

    public function __invoke(CallToolRequest $request, SessionInterface $session): Response|Error
    {
        return new Response(
            $request->getId(),
            new CallToolResult([
                new TextContent("Hello " . $request->arguments['name'] . "!"),
            ])
        );
    }
}
```

Example of tool [registration](#tools-1) in `app/Registry/Tools.php`:

```php
public static array $tools = [
    ExampleTool::class
    // Other tools...
];
```

### Resources

Resources are defined in the `app/Resources/` directory. Each resource class must extend the abstract class
`AbstractResource` and be [registered](#resources-1) in the `app/Registry/Resources.php` file.

#### Required Implementation Elements

Every resource must define the following properties:

- **Resource Name**: `protected string $name`
- **Resource URI**: `protected string $uri`

#### Optional Elements

The following properties may be defined to provide additional information:

- **Description**: `protected ?string $description`
- **MIME Type**: `protected ?string $mimeType`
- **Size**: `protected ?int $size`
- **Icons**: `protected ?array $icons`
- **Metadata**: `protected ?array $meta`
- **Resource Annotations**: To specify resource annotations, the `getAnnotations()` method can be overridden. It should
  return an instance of `Mcp\Schema\ResourceAnnotations` or `null` if no annotations are needed.

Example of creating a resource:

```php
namespace App\Resources;

final class ExampleResource extends AbstractResource
{
    protected string $name = 'example_resource';

    protected string $uri = 'example://example';

    protected ?string $mimeType = 'text/plain';

    public function __invoke(ReadResourceRequest $request, SessionInterface $session): Response|Error
    {
        return new Response(
            $request->getId(),
            new ReadResourceResult([
                new TextResourceContents(
                    $this->uri,
                    $this->mimeType,
                    'Example resource content'
                ),
            ])
        );
    }
}
```

Example of resource [registration](#resources-1) in `app/Registry/Resources.php`:

```php
public static array $resources = [
    ExampleResource::class,
    // Other resources...
];
```

### Prompts

Prompts are defined in the `app/Prompts/` directory. Each prompt class must extend the abstract class `AbstractPrompt`
and be [registered](#prompts-1) in the `app/Registry/Prompts.php` file.

#### Required Implementation Elements

Every prompt must define the following property:

- **Prompt Name**: `protected string $name`

#### Optional Elements

The following properties may be defined to provide additional information:

- **Description**: `protected ?string $description`
- **Arguments**: `protected ?array $arguments`
- **Icons**: `protected ?array $icons`
- **Metadata**: `protected ?array $meta`

Example of creating a prompt:

```php
namespace App\Prompts;

use App\Prompts\AbstractPrompt;

final class ExamplePrompt extends AbstractPrompt
{
    protected string $name = 'example_prompt';

    public function __invoke(GetPromptRequest $request, SessionInterface $session): Response|Error
    {
        return new Response(
            $request->getId(),
            new GetPromptResult([
                new PromptMessage(
                    Role::User,
                    new TextContent('example_message')
                )
            ])
        );
    }
}
```

Example of prompt [registration](#prompts-1) in `app/Registry/Prompts.php`:

```php
public static array $prompts = [
    ExamplePrompt::class,
    // Other prompts...
];
```

### Providers

Service providers, located in the `app/Providers/` directory, are responsible for registering dependencies in the PHP-DI
container, making them accessible to the application. Providers are categorized as follows:

- `ApplicationProviders/`: Providers essential for application functionality. They are loaded first.
- `Providers/`: Custom providers for specific logic.

Each provider must implement the `ProviderInterface` and be [registered](#providers-1) in the
`app/Registry/Providers.php` file

Example of creating a provider:

```php
namespace App\Providers;

final readonly class DBALProvider implements ProviderInterface
{
    public static function register(): array
    {
        return [DatabaseManager::class => new DatabaseManager(
            new CycleDatabaseConfig(
                DatabaseConfig::config()
            )
        )];
    }
}
```

Example of [registration](#providers-1) in `app/Registry/Providers.php`):

```php
private static array $appProviders = [
    \App\Providers\LoggerProvider::class,
    \App\Providers\DBALProvider::class,
];

private static array $providers = [
    // Custom providers
];
```

### Bootstrappers

Bootstrapper classes in the `app/Bootstrappers/` directory initialize key application components. The primary
bootstrappers are:

- `ServerBootstrapper`: Initializes the MCP server.
- `ContainerBootstrapper`: Configures the PHP-DI container.
- `ProvidersBootstrapper`: Initializes [providers](#providers).
- `ToolsBootstrapper`: Initializes [tools](#tools).
- `ResourcesBootstrapper`:Initializes [resources](#resources)
- `PromptsBootstrapper`: Initializes [prompts](#prompts)

The `Kernel.php` file manages the initialization process.

## Registry

The Registry is the central place for registering all core components that your application exposes to MCP-based agents.
It ensures that Tools, Resources, Prompts, and Providers are recognized by the system and can be initialized
automatically via the bootstrappers.

The `app/Registry` directory contains four key files:

- Providers.php
- Resources.php
- Tools.php
- Prompts.php

Each file defines a static array of class references that the application uses to bootstrap and manage components.

### Providers

Service providers are responsible for registering dependencies in the PHP-DI container. Providers are categorized into:

1. **Application Providers** (`$appProviders`) – essential for the core functionality of the application and loaded
   first.

2. **Custom Providers** (`$providers`) – optional, used for registering application-specific services.

#### Example:

```php
final class Providers
{
    /** @var array<class-string<ProviderInterface>> */
    public static array $providers = [];

    /** @var array<class-string<ProviderInterface>> */
    public static array $appProviders = [
        LoggerProvider::class
    ];
}
```

**Usage:** Each provider must implement `ProviderInterface` and define a `register()` method returning an array of class
bindings.

### Resources

Resources represent any external or internal content your agent can access. Each resource class must extend
`AbstractResource` and be registered in `app/Registry/Resources.php`:

```php
final class Resources
{
    /** @var array<class-string<AbstractResource>> */
    public static array $resources = [
        ExampleResource::class
    ];
}
```

### Tools

Tools are encapsulated units of functionality that your agent can call. Each tool class must extend `AbstractTool` and
be registered in `app/Registry/Tools.php`:

```php
final class Tools
{
    /** @var array<class-string<AbstractTool>> */
    public static array $tools = [
        ExampleTool::class
    ];
}
```

### Prompts

Prompts define reusable LLM message templates. Each prompt class must extend `AbstractPrompt` and be registered in
`app/Registry/Prompts.php`:

```php
final class Prompts
{
    /** @var array<class-string<AbstractPrompt>> */
    public static array $prompts = [
        ExamplePrompt::class
    ];
}
```

## License

The project is distributed under the MIT License. For details, refer to the [LICENSE](LICENSE) file.

<!-- LINKS -->

[github-release-link]: https://github.com/anvilm/mcp-php-boilerplate/releases

[github-release-shield]: https://img.shields.io/github/v/release/anvilm/mcp-php-boilerplate?style=flat-square&sort=semver&logo=github&labelColor=black

[github-release-date-link]: https://github.com/anvilm/mcp-php-boilerplate/releases

[github-release-date-shield]: https://img.shields.io/github/release-date/anvilm/mcp-php-boilerplate?labelColor=black&style=flat-square

[github-license-link]: https://github.com/anvilm/mcp-php-boilerplate/blob/master/LICENSE

[github-license-shield]: https://img.shields.io/github/license/anvilm/mcp-php-boilerplate?color=white&labelColor=black&style=flat-square

[status-link]: https://github.com/AnvilM/mcp-php-boilerplate/

[status-shield]: https://img.shields.io/badge/status-active-brightgreen?labelColor=black&style=flat-square

[last-commit-link]: https://github.com/AnvilM/mcp-php-boilerplate/commits

[last-commit-shield]: https://img.shields.io/github/last-commit/anvilm/mcp-php-boilerplate?labelColor=black&style=flat-square

[phpstan-link]: https://github.com/AnvilM/mcp-php-boilerplate/

[phpstan-shield]: https://img.shields.io/badge/PHPStan-Level%20max-blue?logo=php&labelColor=black&style=flat-square

[php-version-link]: https://github.com/AnvilM/mcp-php-boilerplate/

[php-version-shield]: https://img.shields.io/badge/PHP-8.4-blue?logo=php&labelColor=black&style=flat-square