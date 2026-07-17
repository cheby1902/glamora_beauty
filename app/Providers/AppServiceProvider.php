<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Pesanan;
use App\Models\Review;

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
        View::composer('*', function ($view) {

            $jumlahNotifikasi = 0;

            if (session()->has('user_id')) {

                    $jumlahNotifikasi = Pesanan::with('detailPesanan')
                    ->where('id_user', session('user_id'))
                    ->where('status_dibaca', 0)
                    ->get()
                    ->filter(function ($pesanan) {

                        // selain Sudah Tiba tetap dihitung
                        if ($pesanan->status_pesanan != 'Sudah Tiba') {
                            return true;
                        }

                        // kalau Sudah Tiba cek review
                        foreach ($pesanan->detailPesanan as $detail) {

                            $sudahReview = Review::where(
                                'id_user',
                                session('user_id')
                            )
                            ->where(
                                'id_produk',
                                $detail->id_produk
                            )
                            ->exists();

                            if (!$sudahReview) {
                                return true;
                            }
                        }
                        return false;
                    })
                    ->count();
            }
            $view->with(
                'jumlahNotifikasi',
                $jumlahNotifikasi
            );

        });
    }
}