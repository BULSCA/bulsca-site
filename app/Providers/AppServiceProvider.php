<?php

namespace App\Providers;

use App\View\Components\FormInput;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CompetitionRepository;
use App\Interfaces\CompetitionRepositoryInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blade::directive('th', function ($expression) {
            return "<?php echo (new \NumberFormatter('en_US', NumberFormatter::ORDINAL))->format({$expression}); ?>";
        });
        $this->app->bind(CompetitionRepositoryInterface::class, CompetitionRepository::class);
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
