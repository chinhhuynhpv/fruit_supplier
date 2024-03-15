<?php

namespace App\Policies;

use App\Models\Staff;
use App\Models\Invoice;
use Illuminate\Auth\Access\Response;

class InvoicePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(Staff $staff): Response
    {
        return $staff->id ? Response::allow(): Response::denyAsNotFound();;
    }

    public function detail(Staff $staff, Invoice $invoice): Response
    {
        return $staff->id === $invoice->staff_id
                    ? Response::allow()
                    : Response::denyAsNotFound();
    }

    public function create(Staff $staff): Response
    {
        // should check if user is a staff
        return $staff->id ? Response::allow() : Response::denyAsNotFound();
    }

    public function delete(Staff $staff, Invoice $invoice): Response
    {
        // should check if staff is a persion who create $invoice
        return $staff->id === $invoice->staff_id
                    ? Response::allow()
                    : Response::denyAsNotFound();;
    }

    public function update(Staff $staff, Invoice $invoice): Response
    {
        // should check if staff is a persion who create $invoice
        return $staff->id === $invoice->staff_id
                    ? Response::allow()
                    : Response::denyAsNotFound();;
    }
}
