<?php

namespace Database\Factories;

use Domain\Order\Models\PaymentHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentHistory>
 */
class PaymentHistoryFactory extends Factory
{
    protected $model = PaymentHistory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

        ];
    }
}
