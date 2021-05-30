<?php

declare(strict_types=1);

namespace Codeat3\BladeBytesizeIcons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;

final class BladeBytesizeIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-bytesize-icons', []);

            $factory->add('bytesize-icons', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });

    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-bytesize-icons.php', 'blade-bytesize-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-bytesize-icons'),
            ], 'blade-bytesize-icons');

            $this->publishes([
                __DIR__.'/../config/blade-bytesize-icons.php' => $this->app->configPath('blade-bytesize-icons.php'),
            ], 'blade-bytesize-icons-config');
        }
    }

}
