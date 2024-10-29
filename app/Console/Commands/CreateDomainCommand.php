<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CreateDomainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @example php artisan make:domain User
     * @var string
     */
    protected $signature = 'make:domain {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create domain folder structure';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $start = now();
        $this->info('Creating domain folder structure...');

        Artisan::call('make:api', [
            'name' => $this->argument('name'),
        ]);

        Artisan::call('make:controller', [
            'name' => $this->argument('name') . 'Controller',
            'boundedContext' => $this->argument('name'),
            'domain' => $this->argument('name'),
        ]);

        Artisan::call('make:dto', [
            'name' => $this->argument('name') . 'DTO',
            'boundedContext' => $this->argument('name'),
        ]);

        Artisan::call('make:mapper', [
            'name' => $this->argument('name') . 'Mapper',
            'boundedContext' => $this->argument('name'),
            'domain' => $this->argument('name'),
        ]);

        Artisan::call('make:model', [
            'name' => $this->argument('name'),
        ]);

        Artisan::call('make:provider', [
            'name' => $this->argument('name') . 'ServiceProvider',
            'domain' => $this->argument('name'),
        ]);

        Artisan::call('make:repository', [
            'name' => $this->argument('name') . 'Repository',
            'domain' => $this->argument('name'),
        ]);

        Artisan::call('make:request', [
            'name' => 'Create' .$this->argument('name') . 'Request',
            'boundedContext' => $this->argument('name'),
        ]);

        Artisan::call('make:request', [
            'name' => 'Update' .$this->argument('name') . 'Request',
            'boundedContext' => $this->argument('name'),
        ]);

        Artisan::call('make:service', [
            'name' => $this->argument('name') . 'Service',
            'domain' => $this->argument('name'),
        ]);

        Artisan::call('make:use-case', [
            'name' => 'Create' . $this->argument('name') . 'UseCase',
            'domain' => $this->argument('name'),
        ]);

        Artisan::call('make:use-case', [
            'name' => 'Delete' . $this->argument('name') . 'UseCase',
            'domain' => $this->argument('name'),
        ]);

        Artisan::call('make:use-case', [
            'name' => 'Get' . $this->argument('name') . 'ByIdUseCase',
            'domain' => $this->argument('name'),
        ]);

        Artisan::call('make:use-case', [
            'name' => 'Update' . $this->argument('name') . 'UseCase',
            'domain' => $this->argument('name'),
        ]);

        //Add content to provider.php
        $providerPath = base_path('bootstrap/providers.php');
        $content = File::get($providerPath);
        $newProvider = 'App\\'. $this->argument('name') . '\\Infrastructure\\Providers\\'. $this->argument('name') .'ServiceProvider::class,';
        if (!str_contains($content, $newProvider)) {
            $content = str_replace('];', "    $newProvider\n];", $content);
            File::put($providerPath, $content);

            $this->info('Provider added successfully!');
        } else {
            $this->info('Provider already exists in bootstrap/providers.php');
        }

        $this->info('Domain folder structure created successfully!, took: ' . now()->diffInSeconds($start) . ' seconds');
    }
}
