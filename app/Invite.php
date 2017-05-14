<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;

class Invite extends Model
{
    protected $fillable = ['email'];

    public static function getInviteByCode($code) {
        return Invite::where('code', $code)->where('claimed', NULL)->first();
    }

    protected function generateInviteCode() {
        $this->code = bin2hex(openssl_random_pseudo_bytes(16));
    }

    public function sendInvitation() {
        $params = [
            'code' => $this->code,
        ];
        Mail::send('email.invite', $params, function ($message) {
            $message->to($this->email)->subject('Invite to site');
        });
    }

    public function invitee() {
        return $this->belongsTo('App\User', 'invitee_id');
    }

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            $model->generateInviteCode();
        });
    }
}
