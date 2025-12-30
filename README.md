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
- **Testing**: [Pest](https://pestphp.com/)
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
│   ├── Bootloaders/            # Classes for initializing application components
│   ├── Config/                   # Configuration files
│   ├── Tools/                    # MCP Tools definitions
│   ├── Resources/                # MCP resources definitions
│   ├── Prompts/                  # MCP prompts definitions
│   ├── Providers/                # Dependency injection container providers
│   │   ├── ApplicationProviders/ # Providers for application functionality
│   │   └── Providers/            # Custom providers
│   └── Kernel.php                # Application entry point and bootstrap management
├── entrypoint/
│   ├── http.php                  # HTTP entry point
│   └── stdio.php                 # Stdio (stdin/stdout) entry point
├── src/                          # Source code for custom logic
└── tests/                        # Pest tests
```

### Directory Organization

The boilerplate is structured to separate infrastructural logic from user-defined code:

- **Directory `app/`**: Contains the core infrastructure of the application,
  including [configurations](#configuration), [providers](#providers), [tools](#tools), [resources](#resources), [prompts](#prompts)
  and [bootloaders](#bootloaders). This directory is intended for foundational application setup and operation.
- **Directory `src/`**: Designated for user-defined source code, where developers can implement the primary business
  logic of the application.

### Configuration

Application configurations are organized in the `app/Config/` directory and provide type-safe access to settings via
classes with static methods. For further details, refer to the [Configuration](#configuration-1) section.

#### Environment Variables

Environment variables are loaded from a `.env` file in the project root during the bootstrapping process (specifically within the `InfrastructureBootloader`).

After loading, all variables are available globally via the `$_ENV` superglobal array.

Predefined environment variables:

- **APP_ENV**: Defines the application environment (e.g., `production`, `development`), affecting logging levels.
- **APP_DEBUG**: Enables or disables debug mode, influencing the display of detailed error information.
- **APP_NAME**: Name of the application.
- **APP_DESCRIPTION**: Short description of the application.

Additional custom variables can be added as needed.

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

Tools are defined in the `app/Tools/` directory.

Example of creating a tool:

```php
namespace Application\Tools;

use Mcp\Capability\Attribute\McpTool;

class ExampleTool
{
    #[McpTool("example_tool", "Example tool description")]
    public function handle(string $name): string
    {
        return "Hello $name";
    }
}
```

### Resources

Resources are defined in the `app/Resources/` directory.

Example of creating a resource:

```php
namespace Application\Resources;

use Mcp\Capability\Attribute\McpResource;

final class ExampleResource
{
    #[McpResource("example://example", "example_resource", "Example resource description", "text/plain")]
    public function handle(): string
    {
        return "example resource";
    }

}
```

### Prompts

Prompts are defined in the `app/Prompts/` directory.

Example of creating a prompt:

```php
namespace Application\Prompts;

use ...

final class ExamplePrompt
{
    #[McpPrompt("example_prompt")]
    public function handle(): PromptMessage
    {
        return new PromptMessage(
            Role::User,
            new TextContent("example prompt message"),
        );
    }
}
```

### Providers

Service providers, located in the `app/Providers/` directory, are responsible for registering dependencies in the PHP-DI
container, making them accessible to the application. Providers are categorized as follows:

- `ApplicationProviders/`: Providers essential for application functionality. **They are loaded first.**
- `Providers/`: Custom providers for specific logic.

Each provider must implement the `ProviderInterface` and be registered in the `app/Providers/Registry.php` file.

ApplicationProviders must be registered in the `$appProviders` array, other Providers in the `$providers` array.

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

Example of registration in the `app/Providers/Registry.php` file:

```php
private static array $appProviders = [
    \App\Providers\LoggerProvider::class,
    \App\Providers\DBALProvider::class,
];

private static array $providers = [
    // Other providers
];
```

### Bootloaders

The application bootstrapping process is divided into distinct stages to ensure a scalable, ordered, and predictable
initialization of components. Each stage is managed by a dedicated bootloader, allowing components to be loaded
sequentially rather than in a single monolithic location.

All bootloaders are located in the `app/Bootloaders/` directory and must implement the `BootloaderInterface`. The
`Kernel` class defines the execution order of these stages and orchestrates the entire bootstrapping process.

#### Directory Structure

```
app/Bootloaders/
├── Application/
│   ├── ApplicationBootloader.php
│   └── Server.php
├── Infrastructure/
│   ├── Container.php
│   ├── Providers.php
│   ├── Environment.php
│   └── InfrastructureBootloader.php
├── BootloaderInterface.php
└── Context.php
```

#### Boot Sequence

The bootloaders are executed in the following order:

1. **InfrastructureBootloader**  
   Configures core infrastructure components, including the PHP-DI container and environment variables.

2. **ApplicationBootloader**  
   Initializes the MCP server and other application-level components.

Additional bootloaders can be inserted at appropriate positions in the sequence as the application evolves.

#### Extending the Boot Process

To add a new bootloader:

1. Create a new directory and class under `app/Bootloaders/`, for example: `app/Bootloaders/OneMoreBootloader/OneMoreBootloader.php`

2. Implement the `BootloaderInterface` in the new class:

```php
<?php
namespace Application\Bootloaders\OneMoreBootloader;

...

/**
 * @implements BootloaderInterface<array{container: DiContainer}, array{container: DIContainer}>
 */
class OneMoreBootloader implements BootloaderInterface
{
    /**
     * @param Context<array{container: DiContainer}> $context
     * @return Context<array{container: DIContainer}>
     */
    public static function boot(Context $context): Context
    {
        $context->get('container')->get(LoggerInterface::class)->debug("OneMoreBootloader: booted");
        
        return new Context(['container' => $context->get('container')]);
    }
}
```

3. Register the new bootloader in the `Kernel` class by adding it to the bootloaders array in the correct position:

```php
namespace Application;

...

final readonly class Kernel
{
    
    ...
    
    public static function createServer(): McpServer
    {
        /** @var Context<array{container: DIContainer}> $infrastructureContext */
        $infrastructureContext = InfrastructureBootloader::boot(new Context());

        /** @var Context<array{container: DIContainer}> $oneMoreBootloaderContext */
        $oneMoreBootloaderContext = OneMoreBootloader::boot($infrastructureContext);

        /** @var Context<array{server: McpServer}> $applicationContext */
        $applicationContext = ApplicationBootloader::boot($oneMoreBootloaderContext);


        return $applicationContext->get('server');
    }
}
```

This approach ensures that new functionality can be introduced in a controlled manner without disrupting existing
initialization logic.

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

[phpstan-shield]: https://img.shields.io/badge/PHPStan-Level%208-blue?logo=php&labelColor=black&style=flat-square

[php-version-link]: https://github.com/AnvilM/mcp-php-boilerplate/

[php-version-shield]: https://img.shields.io/badge/PHP-8.5-blue?logo=php&labelColor=black&style=flat-square