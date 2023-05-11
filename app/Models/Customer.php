<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand_name',
        'brand_logo',
        'company_name',
        'tax_number',
        'contact_person_name',
        'contact_person_phone',
        'company_address',
        'shop_location',
        'start_date',
        'end_date',
    ];
}
