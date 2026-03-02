<?php

namespace App\Providers;

use App\View\Components\FormInput;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ArticleRepositoryInterface;
use App\Repositories\ArticleRepository;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        Blade::directive('th', function ($expression) {
            return "<?php echo (new \NumberFormatter('en_US', NumberFormatter::ORDINAL))->format({$expression}); ?>";
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('form-input', FormInput::class);
    }
}
