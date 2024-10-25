<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;

class CreateMapperCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     * @example php artisan make:mapper UserMapper User User
     * @var string
     */
    protected $signature = 'make:mapper {name} {boundedContext} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Mapper and MapperInterface for Domain-Driven Design';

    /**
     * Execute the console command.
     * @throws FileNotFoundException
     */
    public function handle() : void
    {
        // Generate Mapper
        if ($this->alreadyExists($this->qualifyClass($this->argument('name'), 'Mapper'))) {
            $this->error('Mapper already exists!');
            return;
        }
        $this->createMapper();

        // Generate MapperInterface
        if ($this->alreadyExists($this->qualifyClass($this->argument('name'), 'MapperInterface'))) {
            $this->error('MapperInterface already exists!');
            return;
        }
        $this->createMapperInterface();
    }

    /**
     * @throws FileNotFoundException
     */
    protected function createMapper(): void
    {
        $name = $this->argument('name');
        $boundedContext = $this->argument('boundedContext');
        $domain = $this->argument('domain');

        $path = $this->getPath($this->qualifyClass($name, 'Mapper'));

        $this->makeDirectory($path);

        $stub = $this->files->get(resource_path('stubs/Mapper.stub'));

        $this->files->put($path, $this->replacePlaceholders($stub, $name, $boundedContext, $domain));

        $this->info('Mapper created successfully.');
    }

    /**
     * @throws FileNotFoundException
     */
    protected function createMapperInterface(): void
    {
        $name = $this->argument('name');
        $boundedContext = $this->argument('boundedContext');
        $domain = $this->argument('domain');

        $path = $this->getPath($this->qualifyClass($name, 'MapperInterface'));

        $this->makeDirectory($path);

        $stub = $this->files->get(resource_path('stubs/MapperInterface.stub'));

        $this->files->put($path, $this->replacePlaceholders($stub, $name, $boundedContext, $domain));

        $this->info('MapperInterface created successfully.');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return '';
    }

    /**
     * Replace the placeholders in the stub with the corresponding values.
     *
     * @param string $stub
     * @param string $name
     * @param string $boundedContext
     * @param string $domain
     * @return string
     */
    protected function replacePlaceholders(string $stub, string $name, string $boundedContext, string $domain): string
    {
        $domainLc = strtolower($domain);

        $stub = str_replace('{{ namespace }}', "App\\$boundedContext", $stub);
        $stub = str_replace('{{ domain }}', $domain, $stub);
        $stub = str_replace('{{ domain_lc }}', $domainLc, $stub);

        return str_replace('{{ class }}', $name, $stub);
    }

    protected function qualifyClass($name, $type = '') : string
    {
        $boundedContext = $this->argument('boundedContext');
        $domain = $this->argument('domain');

        if ($type == 'Mapper') {
            return "App\\$boundedContext\\Infrastructure\\Mappers\\{$domain}Mapper";
        } elseif ($type == 'MapperInterface') {
            return "App\\$boundedContext\\Application\\Mappers\\{$domain}MapperInterface";
        }

        return '';
    }

    protected function alreadyExists($rawName): bool
    {
        return $this->files->exists($this->getPath($rawName));
    }

    /**
     * Get the path for the class file being generated.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        return base_path(str_replace('\\', '/', $name)) . '.php';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the mapper'],
            ['boundedContext', InputArgument::REQUIRED, 'The bounded context for the domain (e.g., User)'],
            ['domain', InputArgument::REQUIRED, 'The domain for the mapper (e.g., User)'],
        ];
    }
}
