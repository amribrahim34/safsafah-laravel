<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'payment_method'    => $this->payment_method,
            'payment_status'    => $this->payment_status,
            'transaction_id'    => $this->transaction_id,
            'currency'          => $this->currency,
            'amount'            => $this->amount,
            'proof_of_payment'  => $this->proof_of_payment,
            'proof_uploaded_at' => $this->proof_uploaded_at,
            'verified_at'       => $this->verified_at,
            'rejection_reason'  => $this->rejection_reason,
        ];
    }
}
