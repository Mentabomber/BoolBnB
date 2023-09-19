<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\Apartment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function index($id)
    {
        $user = Auth::user();
        $userApartment = Apartment::findOrFail($id);
        
        $userApartmentIds = $userApartment->pluck('id')->toArray();

        $views = Visit::whereIn('apartment_id', $userApartmentIds)->get();

        // Calcola le visualizzazioni totali per ciascun appartamento
        $apartmentViews = $views->groupBy('apartment_id')->map(function ($views) {
            // calcola le visualizzazioni per ogni anno e mese per ciascun appartamento
            $viewsByYear = $views->groupBy(function ($view) {
                $visitDate = $view->visit_date;
                if (is_string($visitDate)) {
                    $visitDate = Carbon::parse($visitDate);
                }
                return $visitDate->format('Y');
            });

            $yearlyViews = $viewsByYear->map(function ($views) {
                return count($views);
            });

            // calcola le visualizzazioni per ogni mese per ciascun appartamento
            $viewsByMonth = $views->groupBy(function ($view) {
                $createdAt = $view->created_at;
                if (is_string($createdAt)) {
                    $createdAt = Carbon::parse($createdAt);
                }
                return $createdAt->format('F Y');
            });

            $monthlyViews = $viewsByMonth->map(function ($views) {
                return count($views);
            });

            // calcola le visualizzazioni per ogni anno e mese per ciascun appartamento
            $yearlyMonthlyViews = $viewsByYear->map(function ($views) use ($viewsByMonth) {
                $yearlyMonthlyViews = [];
                foreach ($viewsByMonth as $month => $monthViews) {
                    $yearlyMonthlyViews[$month] = count($monthViews);
                }
                return $yearlyMonthlyViews;
            });

            return [
                'total_views' => count($views),
                'yearly_views' => $yearlyViews,
                'monthly_views' => $monthlyViews,
                'yearly_monthly_views' => $yearlyMonthlyViews,
            ];
        });

        $viewsByApartmentAndYear = $views->groupBy('apartment_id')
            ->map(function ($apartmentViews) {
                return $apartmentViews->groupBy(function ($view) {
                    $visitDate = $view->visit_date;
                    if (is_string($visitDate)) {
                        $visitDate = Carbon::parse($visitDate);
                    }
                    return $visitDate->format('Y'); // Raggruppa per anno
                })->map(function ($viewsByYear) {
                    return $viewsByYear->groupBy(function ($view) {
                        $visitDate = $view->visit_date;
                        if (is_string($visitDate)) {
                            $visitDate = Carbon::parse($visitDate);
                        }
                        return $visitDate->format('F Y'); // Raggruppa per mese e anno
                    })->map(function ($viewsByMonth) {
                        return count($viewsByMonth);
                    });
                });
            });

        // / calcola le visualizzazioni per ogni anno e mese per ciascun appartamento
        $yearlyMonthlyViews = $apartmentViews->map(function ($apartmentViews) {
            $yearlyMonthlyViews = [];
            foreach ($apartmentViews['yearly_monthly_views'] as $yearlyMonthlyView) {
                foreach ($yearlyMonthlyView as $month => $views) {
                    if (!isset($yearlyMonthlyViews[$month])) {
                        $yearlyMonthlyViews[$month] = 0;
                    }
                    $yearlyMonthlyViews[$month] += $views;
                }
            }
            return $yearlyMonthlyViews;
        });


        $viewsByYear = $views->groupBy(function ($view) {
            $visitDate = $view->visit_date;
            if (is_string($visitDate)) {
                $visitDate = Carbon::parse($visitDate);
            }
            return $visitDate->format('Y');
        });

        $yearlyViews = $viewsByYear->map(function ($views) {
            return count($views);
        });


        $viewsByMonth = $views->groupBy(function ($view) {
            $createdAt = $view->created_at;
            if (is_string($createdAt)) {
                $createdAt = Carbon::parse($createdAt);
            }
            return $createdAt->format('F Y');
        });

        $monthlyViews = $viewsByMonth->map(function ($views) {
            return count($views);
        });

        $years = [];

        // Loop per ogni visualizzazione per trovare l'anno
        foreach ($views as $view) {
            $visitDate = $view->visit_date;
            if (is_string($visitDate)) {
                $visitDate = Carbon::parse($visitDate);
            }
            $year = $visitDate->format('Y');

            // Se l'anno non è già stato aggiunto, aggiungilo
            if (!in_array($year, $years)) {
                $years[] = $year;
            }
        }

        // Ordina gli anni in ordine crescente
        rsort($years);

        return view('auth.apartments.statistics.stats', compact('views', 'user', 'years', 'userApartmentIds', 'apartmentViews', 'userApartment', 'yearlyViews', 'monthlyViews', 'yearlyMonthlyViews',  'viewsByApartmentAndYear'));
    }
}