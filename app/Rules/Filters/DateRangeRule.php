<?php

namespace App\Rules\Filters;

use Closure;
use DateTime;
use Exception;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class DateRangeRule implements DataAwareRule, ValidationRule
{
    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    public int $allowedDayDiff;

    /**
     * @param int $allowedDayDiff
     */
    public function __construct(int $allowedDayDiff = 10)
    {
        $this->allowedDayDiff = $allowedDayDiff;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     * @throws Exception
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->data['dateFrom'] === null || $this->data['dateTo'] === null) {
            return;
        }

        $from = new DateTime($this->data['dateFrom']);
        $to = new DateTime($this->data['dateTo']);

        if ($from->diff($to)->days > $this->allowedDayDiff) {
            $fail('Date difference should be less than or equal to ' . $this->allowedDayDiff . ' day/s.');
        }
    }

    /**
     * @param array $data
     * @return DateRangeRule|$this
     */
    public function setData(array $data): DateRangeRule|static
    {
        $this->data = $data;
        return $this;
    }
}
