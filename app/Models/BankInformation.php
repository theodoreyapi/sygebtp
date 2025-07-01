<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankInformation extends Model
{
    protected $fillable = [
        'name_bank',
        'code_bank',
        'code_guichet_bank',
        'number_compte_bank',
        'cle_rib_bank',
        'iban_bank',
        'swift_bank',
        'statut_bank',
        'employe_id',
    ];

    protected $table = 'bank_information';

    protected $primaryKey = 'bank';
}
