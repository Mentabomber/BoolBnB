<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index($id)
    {
        $user = Auth::user();
        $userApartment = Apartment::findOrFail($id);
        
        $userApartmentIds = $userApartment->pluck('id')->toArray();

        $Messages = Message::whereIn('apartment_id', $userApartmentIds)->get();

        // Calcola le visualizzazioni totali per ciascun appartamento
        $apartmentMessages = $Messages->groupBy('apartment_id')->map(function ($Messages) {
            // calcola le visualizzazioni per ogni anno e mese per ciascun appartamento
            $MessagesByYear = $Messages->groupBy(function ($message) {
                $sendDate = $message->send_date;
                if (is_string($sendDate)) {
                    $sendDate = Carbon::parse($sendDate);
                }
                return $sendDate->format('Y');
            });

            $yearlyMessages = $MessagesByYear->map(function ($Messages) {
                return count($Messages);
            });

            // calcola le visualizzazioni per ogni mese per ciascun appartamento
            $MessagesByMonth = $Messages->groupBy(function ($message) {
                $createdAt = $message->created_at;
                if (is_string($createdAt)) {
                    $createdAt = Carbon::parse($createdAt);
                }
                return $createdAt->format('F Y');
            });

            $monthlyMessages = $MessagesByMonth->map(function ($Messages) {
                return count($Messages);
            });

            // calcola le visualizzazioni per ogni anno e mese per ciascun appartamento
            $yearlyMonthlyMessages = $MessagesByYear->map(function ($Messages) use ($MessagesByMonth) {
                $yearlyMonthlyMessages = [];
                foreach ($MessagesByMonth as $month => $monthMessages) {
                    $yearlyMonthlyMessages[$month] = count($monthMessages);
                }
                return $yearlyMonthlyMessages;
            });

            return [
                'total_Messages' => count($Messages),
                'yearly_Messages' => $yearlyMessages,
                'monthly_Messages' => $monthlyMessages,
                'yearly_monthly_Messages' => $yearlyMonthlyMessages,
            ];
        });

        $MessagesByApartmentAndYear = $Messages->groupBy('apartment_id')
            ->map(function ($apartmentMessages) {
                return $apartmentMessages->groupBy(function ($message) {
                    $sendDate = $message->send_date;
                    if (is_string($sendDate)) {
                        $sendDate = Carbon::parse($sendDate);
                    }
                    return $sendDate->format('Y'); // Raggruppa per anno
                })->map(function ($MessagesByYear) {
                    return $MessagesByYear->groupBy(function ($message) {
                        $sendDate = $message->send_date;
                        if (is_string($sendDate)) {
                            $sendDate = Carbon::parse($sendDate);
                        }
                        return $sendDate->format('F Y'); // Raggruppa per mese e anno
                    })->map(function ($MessagesByMonth) {
                        return count($MessagesByMonth);
                    });
                });
            });

        // / calcola le visualizzazioni per ogni anno e mese per ciascun appartamento
        $yearlyMonthlyMessages = $apartmentMessages->map(function ($apartmentMessages) {
            $yearlyMonthlyMessages = [];
            foreach ($apartmentMessages['yearly_monthly_Messages'] as $yearlyMonthlymessage) {
                foreach ($yearlyMonthlymessage as $month => $Messages) {
                    if (!isset($yearlyMonthlyMessages[$month])) {
                        $yearlyMonthlyMessages[$month] = 0;
                    }
                    $yearlyMonthlyMessages[$month] += $Messages;
                }
            }
            return $yearlyMonthlyMessages;
        });


        $MessagesByYear = $Messages->groupBy(function ($message) {
            $sendDate = $message->send_date;
            if (is_string($sendDate)) {
                $sendDate = Carbon::parse($sendDate);
            }
            return $sendDate->format('Y');
        });

        $yearlyMessages = $MessagesByYear->map(function ($Messages) {
            return count($Messages);
        });


        $MessagesByMonth = $Messages->groupBy(function ($message) {
            $createdAt = $message->created_at;
            if (is_string($createdAt)) {
                $createdAt = Carbon::parse($createdAt);
            }
            return $createdAt->format('F Y');
        });

        $monthlyMessages = $MessagesByMonth->map(function ($Messages) {
            return count($Messages);
        });

        $years = [];

        // Loop per ogni visualizzazione per trovare l'anno
        foreach ($Messages as $message) {
            $sendDate = $message->send_date;
            if (is_string($sendDate)) {
                $sendDate = Carbon::parse($sendDate);
            }
            $year = $sendDate->format('Y');

            // Se l'anno non è già stato aggiunto, aggiungilo
            if (!in_array($year, $years)) {
                $years[] = $year;
            }
        }

        // Ordina gli anni in ordine crescente
        rsort($years);

        return view('auth.apartments.statistics.stats', compact('Messages', 'user', 'years', 'userApartmentIds', 'apartmentMessages', 'userApartment', 'yearlyMessages', 'monthlyMessages', 'yearlyMonthlyMessages',  'MessagesByApartmentAndYear'));
    }
}