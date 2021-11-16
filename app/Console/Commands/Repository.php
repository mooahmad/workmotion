<?php

namespace App\Console\Commands;

use Faker\Core\File;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Repository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo
                            {name : The name for the repository to be created}
                            {--m|model : Whether to create model or not}
    ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a repository for your Application';
    protected $filesystem;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        if (Str::contains($name, '/')) {
            $location = 'app/Repositories/' . substr($name, 0, strrpos($name, '/'));
            $fileDirectoryDetails = explode("/", $name);
            $filename = end($fileDirectoryDetails);
            $modelFullpath = str_replace('/', '\\', $name);
        } else {
            $location = 'app/Repositories';
            $filename = $name;
            $modelFullpath = $name;

        }
        $model = strpos($filename, 'Repository') ? explode('Repository', $filename)[0] : $filename;

        if (file_exists($location . '/' . $filename . '.php')) {
            return $this->error('Repository already exists');
        }
        $this->filesystem->makeDirectory(base_path($location), 0755, true, true);
        if (!$this->filesystem->isDirectory(base_path('app/Domain/Contracts'))) {
            $contractLocation = base_path('app/Domain/Contracts/');
            $repositoryLocation = base_path('app/Domain/Repositories/');
            $this->filesystem->makeDirectory($contractLocation, 0755, true, true);
            $this->filesystem->makeDirectory($repositoryLocation, 0755, true, true);
        }

//        if (!$this->filesystem->isDirectory(base_path('App/Domain/Repositories/Contracts'))) {
//            $contractLocation = base_path('App/Domain/Repositories/Contracts/');
//            $repositoryLocation = base_path('App/Domain/Repositories/');
//            $this->filesystem->makeDirectory($contractLocation, 0755, true, true);
//        }
//        if (isset($contractLocation) && !$this->filesystem->exists($contractLocation . 'RepositoryInterface.php')) {
//            copy(base_path('/stubs/RepositoryInterface.stub'), $contractLocation . 'RepositoryInterface.php');
//        }
//        if (isset($repositoryLocation) && !$this->filesystem->exists($repositoryLocation . 'Repository.php')) {
//            copy(base_path('/stubs/Repository.stub'), $repositoryLocation . 'Repository.php');
//        }
        $namespacedModel = (new \ReflectionClass(substr('App/Repositories', 0, strrpos('App/Repositories', '/')) . '\\Models\\' . $modelFullpath))->getNamespaceName() . '\\' . $model;
        if ($this->option('model')) {
            $this->call('make:model', [
                'name' => $namespacedModel,
            ]);
        }
        //  return $this->error($namespacedModel);


        $namespacedModel = $namespacedModel . ";\nuse App\\Domain\\Repositories\\Repository";

        $ModelNameSpace = 'App\Repositories';

        if (Str::contains($name, '/')) {
            $ModelNameSpace = 'App\Repositories\\' . str_replace('/','\\',substr($name, 0, strrpos($name, '/')));
        }

        $defaultRepositoryContent = $this->filesystem->get(base_path('app/Domain/Stubs/DummyRepository.stub'));
        $runtimeRepositoryContent = str_replace(['DummyNamespace', 'DummyModelNamespace', 'DummyRepository', 'Dummy'], [$ModelNameSpace, $namespacedModel, $filename . 'Repository', ucfirst($model)], $defaultRepositoryContent);
        $this->filesystem->put(base_path('app/Domain/Stubs/DummyRepository.stub'), $runtimeRepositoryContent);
        $this->filesystem->copy(base_path('app/Domain/Stubs/DummyRepository.stub'), $location . '/' . $filename . 'Repository' . '.php');
        $this->filesystem->put(base_path('app/Domain/Stubs/DummyRepository.stub'), $defaultRepositoryContent);
        $this->info('Yeey! Repository created successfully');
    }

}
