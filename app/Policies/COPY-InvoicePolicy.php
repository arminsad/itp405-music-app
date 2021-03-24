<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Invoice;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Invoice $invoice)
    {
        return $user->email === $invoice->customer->email;
    }
}
