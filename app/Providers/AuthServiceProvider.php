<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Book;
use Illuminate\Support\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('read', function (User $user, Peminjaman $peminjaman) {
            $user_match = $user->id == $peminjaman->user_id ;
            $expired_dt = (new Carbon($peminjaman->confirmed_at))->addWeeks(2)->endOfDay();
            $peminjaman_valid= $expired_dt > Carbon::now();

            return $user_match && $peminjaman_valid;
        });

        Gate::define('cancel', function (User $user, Peminjaman $peminjaman) {
            return $user->id == $peminjaman->user_id || $user->is_admin;
        });
    }
}
