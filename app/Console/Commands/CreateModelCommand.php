<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;

class CreateModelCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @example php artisan make:model User
     * @var string
     */
    protected $signature = 'make:model {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

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
        return resource_path('stubs/Model.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $name = $this->argument('name');

        return "$rootNamespace\\$name\\Domain\\Models";
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

        // Replace placeholders in the stub
        $stub = str_replace('{{ namespace }}', $this->getDefaultNamespace($this->rootNamespace()), $stub);

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
            ['name', InputArgument::REQUIRED, 'The name of the model'],
        ];
    }
}
