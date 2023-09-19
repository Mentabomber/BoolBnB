<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Apartment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userApartments = Apartment::where('user_id', $user->id)->get();
        $userApartmentIds = $userApartments->pluck('id')->toArray();

        $messages = Message::whereIn('apartment_id', $userApartmentIds)->get();

        // Calcola le visualizzazioni totali per ciascun appartamento
        $apartmentmessages = $messages->groupBy('apartment_id')->map(function ($messages) {
            // calcola le visualizzazioni per ogni anno e mese per ciascun appartamento
            $messagesByYear = $messages->groupBy(function ($message) {
                $visitDate = $message->visit_date;
                if (is_string($visitDate)) {
                    $visitDate = Carbon::parse($visitDate);
                }
                return $visitDate->format('Y');
            });

            $yearlymessages = $messagesByYear->map(function ($messages) {
                return count($messages);
            });

            // calcola le visualizzazioni per ogni mese per ciascun appartamento
            $messagesByMonth = $messages->groupBy(function ($message) {
                $createdAt = $message->created_at;
                if (is_string($createdAt)) {
                    $createdAt = Carbon::parse($createdAt);
                }
                return $createdAt->format('F Y');
            });

            $monthlymessages = $messagesByMonth->map(function ($messages) {
                return count($messages);
            });

            // calcola le visualizzazioni per ogni anno e mese per ciascun appartamento
            $yearlyMonthlymessages = $messagesByYear->map(function ($messages) use ($messagesByMonth) {
                $yearlyMonthlymessages = [];
                foreach ($messagesByMonth as $month => $monthmessages) {
                    $yearlyMonthlymessages[$month] = count($monthmessages);
                }
                return $yearlyMonthlymessages;
            });

            return [
                'total_messages' => count($messages),
                'yearly_messages' => $yearlymessages,
                'monthly_messages' => $monthlymessages,
                'yearly_monthly_messages' => $yearlyMonthlymessages,
            ];
        });

        $messagesByApartmentAndYear = $messages->groupBy('apartment_id')
            ->map(function ($apartmentmessages) {
                return $apartmentmessages->groupBy(function ($message) {
                    $visitDate = $message->visit_date;
                    if (is_string($visitDate)) {
                        $visitDate = Carbon::parse($visitDate);
                    }
                    return $visitDate->format('Y'); // Raggruppa per anno
                })->map(function ($messagesByYear) {
                    return $messagesByYear->groupBy(function ($message) {
                        $visitDate = $message->visit_date;
                        if (is_string($visitDate)) {
                            $visitDate = Carbon::parse($visitDate);
                        }
                        return $visitDate->format('F Y'); // Raggruppa per mese e anno
                    })->map(function ($messagesByMonth) {
                        return count($messagesByMonth);
                    });
                });
            });

        // / calcola le visualizzazioni per ogni anno e mese per ciascun appartamento
        $yearlyMonthlymessages = $apartmentmessages->map(function ($apartmentmessages) {
            $yearlyMonthlymessages = [];
            foreach ($apartmentmessages['yearly_monthly_messages'] as $yearlyMonthlymessage) {
                foreach ($yearlyMonthlymessage as $month => $messages) {
                    if (!isset($yearlyMonthlymessages[$month])) {
                        $yearlyMonthlymessages[$month] = 0;
                    }
                    $yearlyMonthlymessages[$month] += $messages;
                }
            }
            return $yearlyMonthlymessages;
        });


        $messagesByYear = $messages->groupBy(function ($message) {
            $visitDate = $message->visit_date;
            if (is_string($visitDate)) {
                $visitDate = Carbon::parse($visitDate);
            }
            return $visitDate->format('Y');
        });

        $yearlymessages = $messagesByYear->map(function ($messages) {
            return count($messages);
        });


        $messagesByMonth = $messages->groupBy(function ($message) {
            $createdAt = $message->created_at;
            if (is_string($createdAt)) {
                $createdAt = Carbon::parse($createdAt);
            }
            return $createdAt->format('F Y');
        });

        $monthlymessages = $messagesByMonth->map(function ($messages) {
            return count($messages);
        });

        $years = [];

        // Loop per ogni visualizzazione per trovare l'anno
        foreach ($messages as $message) {
            $visitDate = $message->visit_date;
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

        return message('auth.apartments.statistics.stats', compact('messages', 'user', 'years', 'userApartmentIds', 'apartmentmessages', 'userApartments', 'yearlymessages', 'monthlymessages', 'yearlyMonthlymessages',  'messagesByApartmentAndYear'));
    }
}