<?php

namespace App\Rules;

use App\Models\ProductPrice;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateExistRule implements ValidationRule
{
    protected int $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isExist = ProductPrice::where('product_id', $this->productId)->whereDate($attribute, today())->count() > 0;

        if ($isExist) {
            $fail('The price has been updated today.');
            //            $fail('validation.uppercase')->translate();
        }
    }
}
