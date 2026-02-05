
D:\download\absensi-pelita-lw>composer require livewire/livewire:3.6 -w
The "3.6" constraint for "livewire/livewire" appears too strict and will likely not match what you want. See https://getcomposer.org/constraints
./composer.json has been updated
Running composer update livewire/livewire --with-dependencies
Loading composer repositories with package information
Dependency laravel/framework is also a root requirement. Package has not been listed as an update argument, so keeping locked at old version. Use --with-all-dependencies (-W) to include root dependencies.
Updating dependencies
Lock file operations: 1 install, 11 updates, 0 removals
  - Upgrading laravel/prompts (v0.3.7 => v0.3.10)
  - Locking livewire/livewire (v3.6.0)
  - Upgrading symfony/console (v7.3.5 => v7.4.3)
  - Upgrading symfony/error-handler (v7.3.4 => v7.4.0)
  - Upgrading symfony/event-dispatcher (v7.3.3 => v7.4.0)
  - Upgrading symfony/http-foundation (v7.3.5 => v7.4.3)
  - Upgrading symfony/http-kernel (v7.3.5 => v7.4.3)
  - Upgrading symfony/mime (v7.3.4 => v7.4.0)
  - Upgrading symfony/service-contracts (v3.6.0 => v3.6.1)
  - Upgrading symfony/string (v7.3.4 => v7.4.0)
  - Upgrading symfony/translation-contracts (v3.6.0 => v3.6.1)
  - Upgrading symfony/var-dumper (v7.3.5 => v7.4.3)
Writing lock file
Installing dependencies from lock file (including require-dev)
Package operations: 1 install, 11 updates, 0 removals
  - Downloading symfony/var-dumper (v7.4.3)
  - Downloading symfony/http-foundation (v7.4.3)
  - Downloading symfony/http-kernel (v7.4.3)
  - Downloading symfony/console (v7.4.3)
  - Downloading laravel/prompts (v0.3.10)
  - Downloading livewire/livewire (v3.6.0)
  - Upgrading symfony/var-dumper (v7.3.5 => v7.4.3): Extracting archive
  - Upgrading symfony/mime (v7.3.4 => v7.4.0): Extracting archive
  - Upgrading symfony/service-contracts (v3.6.0 => v3.6.1): Extracting archive
  - Upgrading symfony/event-dispatcher (v7.3.3 => v7.4.0): Extracting archive
  - Upgrading symfony/http-foundation (v7.3.5 => v7.4.3): Extracting archive
  - Upgrading symfony/error-handler (v7.3.4 => v7.4.0): Extracting archive
  - Upgrading symfony/http-kernel (v7.3.5 => v7.4.3): Extracting archive
  - Upgrading symfony/string (v7.3.4 => v7.4.0): Extracting archive
  - Upgrading symfony/console (v7.3.5 => v7.4.3): Extracting archive
  - Upgrading symfony/translation-contracts (v3.6.0 => v3.6.1): Extracting archive
  - Upgrading laravel/prompts (v0.3.7 => v0.3.10): Extracting archive
  - Installing livewire/livewire (v3.6.0): Extracting archive
Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi

   Error

  Call to a member function make() on null  

  at vendor\laravel\framework\src\Illuminate\Console\Command.php:171
    167▕      */
    168▕     #[\Override]
    169▕     public function run(InputInterface $input, OutputInterface $output): int
    170▕     {
  ➜ 171▕         $this->output = $output instanceof OutputStyle ? $output : $this->laravel->make(
    172▕             OutputStyle::class, ['input' => $input, 'output' => $output]
    173▕         );
    174▕
    175▕         $this->components = $this->laravel->make(Factory::class, ['output' => $this->output]);

  1   vendor\symfony\console\Application.php:1102
      Illuminate\Console\Command::run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))

  2   vendor\symfony\console\Application.php:356
      Symfony\Component\Console\Application::doRunCommand(Object(Illuminate\Foundation\Console\PackageDiscoverCommand), Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))

Script @php artisan package:discover --ansi handling the post-autoload-dump event returned with error code 1

D:\download\absensi-pelita-lw>