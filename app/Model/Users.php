<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//*****Created By Usman Abbas*******//
class Users extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = [
                            'userId', 'userName', 'userType', 'gender',
                            'email','imeiNumber', 'mobileNumber', 'password', 'profileImage',
                            'socialId', 'socialType', 'deviceToken', 'deviceType',
                            'authToken', 'isLoggedIn', 'logTime', 'loginStatus',
                            'status', 'Serve_status', 'notapprovedMOT', 'crd', 'upd', 'companyId'
                        ];
}
