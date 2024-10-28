<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;

class CreateProviderCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @example php artisan make:provider UserServiceProvider User
     * @var string
     */
    protected $signature = 'make:provider {name} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Provider';

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
     * @return string
     */
    protected function getStub(): string
    {
        return resource_path('stubs/Provider.stub');
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

        return "$rootNamespace\\$domain\\Infrastructure\\Providers";
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

        // Replace placeholders in the stub
        $stub = str_replace('{{ namespace }}', $this->getDefaultNamespace($this->rootNamespace()), $stub);
        $stub = str_replace('{{ domain }}', $domain, $stub);

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
            ['name', InputArgument::REQUIRED, 'The name of the provider'],
            ['domain', InputArgument::REQUIRED, 'The domain for the provider (e.g., User)'],
        ];
    }
}
