<?php

namespace App\Providers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Level;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Stok;
use App\Models\Supplier;
use App\Models\User;
use App\Policies\BarangPolicy;
use App\Policies\KategoriPolicy;
use App\Policies\LevelPolicy;
use App\Policies\PenjualanDetailPolicy;
use App\Policies\PenjualanPolicy;
use App\Policies\StokPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Level::class, LevelPolicy::class);
        Gate::policy(Kategori::class, KategoriPolicy::class);
        Gate::policy(Supplier::class, SupplierPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Barang::class, BarangPolicy::class);
        Gate::policy(Stok::class, StokPolicy::class);
        Gate::policy(Penjualan::class, PenjualanPolicy::class);
        Gate::policy(PenjualanDetail::class, PenjualanDetailPolicy::class);
    }
}
