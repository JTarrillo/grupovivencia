<?php
namespace App\Models;
use CodeIgniter\Model;

class PenaltyModel extends Model
{
    protected $table = 'penalties';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'contract_id',
        'payment_schedule_id',
        'type',
        'amount',
        'date',
        'notes',
        'created_by',
        'created_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}