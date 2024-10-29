<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreateApiCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @example php artisan make:api Address
     * @var string
     */
    protected $signature = 'make:api {name}';

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
    protected $type = 'Route file';

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
        return resource_path('stubs/Api.stub');
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput(): string
    {
        return 'api';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $domain = $this->argument('name');

        return "$rootNamespace\\$domain\\Presentation\\Routes";
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

        $domain = $this->argument('name');
        $domainLc = strtolower($domain);

        $stub = str_replace('{{ domain }}', $domain, $stub);
        $stub = str_replace('{{ domain_lc }}', $domainLc, $stub);

        return str_replace('{{ class }}', $name, $stub);
    }
}
