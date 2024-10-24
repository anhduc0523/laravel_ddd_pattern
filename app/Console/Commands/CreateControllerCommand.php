<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;

class CreateControllerCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:controller {name} {boundedContext} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller with a custom stub for Domain-Driven Design';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Execute the console command.
     * @throws FileNotFoundException
     */
    public function handle() : void
    {
        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return resource_path('stubs/Controller.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $boundedContext = $this->argument('boundedContext');
        $domain = $this->argument('domain');

        return "$rootNamespace\\$boundedContext\\Presentation\\Http\\Controllers\\Api";
    }

    /**
     * Replace the placeholders in the stub with the corresponding values.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass($stub, $name): string
    {
        $stub = parent::replaceClass($stub, $name);

        // Get the boundedContext and domain from arguments
        $boundedContext = $this->argument('boundedContext');
        $domain = $this->argument('domain');
        $domainLc = strtolower($domain);

        // Replace placeholders in the stub
        $stub = str_replace('{{ namespace }}', $this->getDefaultNamespace($this->rootNamespace()), $stub);
        $stub = str_replace('{{ boundedContext }}', $boundedContext, $stub);
        $stub = str_replace('{{ domain }}', $domain, $stub);
        $stub = str_replace('{{ domain_lc }}', $domainLc, $stub);

        return str_replace('{{ class }}', $name, $stub);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the controller'],
            ['boundedContext', InputArgument::REQUIRED, 'The bounded context for the controller (e.g., User)'],
            ['domain', InputArgument::REQUIRED, 'The domain for the controller (e.g., User)'],
        ];
    }
}
