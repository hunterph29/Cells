<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'zip_code',
        'contract',
    ];

    public function formattedAddress(): string
    {
        $line = trim(implode(', ', array_filter([
            $this->address,
            $this->city,
            $this->zip_code,
        ])));

        return $line !== '' ? $line : '—';
    }
}
