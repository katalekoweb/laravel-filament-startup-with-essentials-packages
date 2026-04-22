<?php

use App\Models\Payment;
use App\Models\Student;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Year;

if (!function_exists('currencyName')) {
    function currencyName($tenant = null)
    {
        $tenant = $tenant ?? request()?->user()?->tenant;
        $country = $tenant?->country;

        return $country?->currency_symbol ?? 'Kz';
    }
}

if (!function_exists('currencyCode')) {
    function currencyCode($tenant = null)
    {
        $tenant = $tenant ?? request()?->user()?->tenant;

        $country = $tenant?->country;

        return $country?->currency_code ?? 'AOA';
    }
}

if (!function_exists('currencyPosition')) {
    function currencyPosition($tenant = null)
    {
        $tenant = $tenant ?? request()?->user()?->tenant;

        $country = $tenant?->country;

        return $country?->currency_position ?? 'after';
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount, $tenant = null, bool $showCurrency = true) : string
    {
        $symbol = currencyName($tenant);
        $position = currencyPosition($tenant);

        $formattedAmount = number_format((float)$amount, 2, ',', '.');

        if (!$showCurrency) return $formattedAmount;

        if ($position === 'before') {
            return $symbol . ' ' . $formattedAmount;
        } else {
            return $formattedAmount . ' ' . $symbol;
        }
    }
}

if (!function_exists('cleanMoney')) {
    function cleanMoney($amount, $currency = "")
    {
        $amount = str_replace([" ", "Kz", "R$", "$", "."], "", $amount);
        $amount = (float) str_replace(",", ".", $amount);
        $amount = (float) number_format($amount, 2, ".", "");

        return $amount;
    }
}


if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return \Carbon\Carbon::parse($date)->locale('pt_BR')->isoFormat('DD [de] MMMM [de] YYYY');
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($date)
    {
        return \Carbon\Carbon::parse($date)->locale('pt_BR')->isoFormat('DD [de] MMMM [de] YYYY [às] HH:mm:ss');
    }
}

if (!function_exists('generateInvoiceHash')) {
    function generateInvoiceHash($invoice) : string {
        $previousHash = Payment::where('id', '<', $invoice->id)
            ->whereIn('type', ['fr', 'fr', 'rb', 'nc', 'nd'])
            ->orderBy('id', 'desc')
            ->value('hash') ?? '';

        // Campos obrigatórios
        $stringToHash =
            $invoice->tenant->doc .
            $invoice->invoice_number .
            $invoice->created_at .
            number_format($invoice->amount_paid, 2, '.', '') .
            $previousHash;

        return hash('sha256', $stringToHash);
    }
}

if (!function_exists('is_not_university')) {
    function is_not_university() {
        return !in_array(request()->user()?->tenant?->type, ['university']);
    }
}

if (!function_exists('is_university')) {
    function is_university() {
        return in_array(request()->user()?->tenant?->type, ['university']);
    }
}

if (!function_exists('tenant')) {
    function tenant() : ?Tenant {
        return request()->user()?->tenant;
    }
}

if (!function_exists('director')) {
    function director() : ?User {
        return User::whereIsActive(1)->whereTenantId(tenant()?->id)->whereHas('position', function ($query) { $query->whereName("Director"); })->first();
    }
}

if (!function_exists('student')) {
    function student() : ?Student {
        return request()->user()->access === "student" ? Student::find(request()->user()?->id) : Student::find(request()->user()?->current_student_id);
    }
}

if (!function_exists('currentYear')) {
    function currentYear() : ?Year {
        return Year::whereIsCurrent(1)->first();
    }
}

if (!function_exists("education_subjects_angola")) {
    function education_subjects_angola () : array {
        return [
            "História", "Goegrafia", "Língua Inglêsa", "Língua Portuguêsa", "Matemática", "EVP", "EMC",
            "Educação Física", "Física", "História", "Biologia", "Educação Laboral", "Higiene e Saúde Escola"
        ];
    }
}
