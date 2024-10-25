<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;

class CreateServiceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @example php artisan make:service UserService User
     * @var string
     */
    protected $signature = 'make:service {name} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Execute the console command.
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $name = $this->qualifyClass($this->getNameInput());

        if ($this->alreadyExists($name)) {
            $this->error($this->type . ' already exists!');

            return;
        }

        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return resource_path('stubs/Service.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $domain = $this->argument('domain');

        return "$rootNamespace\\$domain\\Domain\\Services";
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
        $domain = $this->argument('domain');
        $domainLc = strtolower($domain);

        // Replace placeholders in the stub
        $stub = str_replace('{{ namespace }}', $this->getDefaultNamespace($this->rootNamespace()), $stub);
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
            ['name', InputArgument::REQUIRED, 'The name of the service'],
            ['domain', InputArgument::REQUIRED, 'The domain of the service'],
        ];
    }
}
