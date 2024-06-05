<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'name',
        'doing_business_as',
        'phone',
        'address',
        'city',
        'state_prov',
        'zip',
        'country',
        'contact_name',
        'contact_email',
        'contact_phone',
        'credit_status',
        'prepay_required'
    ];
}
