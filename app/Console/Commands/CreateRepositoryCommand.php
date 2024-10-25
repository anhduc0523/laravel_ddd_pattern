<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;

class CreateRepositoryCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     * @example php artisan make:repository UserRepository User
     * @var string
     */
    protected $signature = 'make:repository {name} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Repository and RepositoryInterface for Domain-Driven Design';

    /**
     * Execute the console command.
     * @throws FileNotFoundException
     */
    public function handle() : void
    {
        // Generate Repository
        if ($this->alreadyExists($this->qualifyClass($this->argument('name'), 'Repository'))) {
            $this->error('Repository already exists!');
            return;
        }
        $this->createRepository();

        // Generate RepositoryInterface
        if ($this->alreadyExists($this->qualifyClass($this->argument('name'), 'RepositoryInterface'))) {
            $this->error('RepositoryInterface already exists!');
            return;
        }
        $this->createRepositoryInterface();
    }

    /**
     * @throws FileNotFoundException
     */
    protected function createRepository(): void
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');
        $boundedContext = $domain;

        $path = $this->getPath($this->qualifyClass($name, 'Repository'));

        $this->makeDirectory($path);

        $stub = $this->files->get(resource_path('stubs/Repository.stub'));

        $this->files->put($path, $this->replacePlaceholders($stub, $name, $boundedContext, $domain));

        $this->info('Repository created successfully.');
    }

    /**
     * @throws FileNotFoundException
     */
    protected function createRepositoryInterface(): void
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');
        $boundedContext = $domain;

        $path = $this->getPath($this->qualifyClass($name, 'RepositoryInterface'));

        $this->makeDirectory($path);

        $stub = $this->files->get(resource_path('stubs/RepositoryInterface.stub'));

        $this->files->put($path, $this->replacePlaceholders($stub, $name, $boundedContext, $domain));

        $this->info('RepositoryInterface created successfully.');
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
        $domain = $this->argument('domain');
        $boundedContext = $domain;

        if ($type == 'Repository') {
            return "App\\$boundedContext\\Infrastructure\\Repositories\\{$domain}Repository";
        } elseif ($type == 'RepositoryInterface') {
            return "App\\$boundedContext\\Domain\\Repositories\\{$domain}RepositoryInterface";
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
            ['name', InputArgument::REQUIRED, 'The name of the Repository'],
            ['domain', InputArgument::REQUIRED, 'The domain for the Repository (e.g., User)'],
        ];
    }
}
