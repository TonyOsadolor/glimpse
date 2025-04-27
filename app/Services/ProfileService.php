<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Participant;

class ProfileService
{
    /**
     * Create User Account
     */
    public function create($data)
    {
        $role = $data['role'];
        $userId = $data['user_id'];

        switch( $role ){
            case( 'participant' ):
                Participant::create(['user_id' => $userId]);
                break;
            case( 'company' ):
                Company::create([
                    'user_id' => $userId,
                    'company_name' => $data['company_name'],
                    'company_ref' => $this->getCompanyRef($userId, $data['company_name']),
                    /**
                     * 'status' => 'pending_approval' default
                     * 'is_active' => false default
                     * 
                     * but for the purpose of testing, I will leave it as active
                     * 'is_active' => true
                     */
                    'status' => 'active',
                    'is_active' => true,
                ]);
                break;
            case( 'admin' ):
                Admin::create(['user_id' => $userId]);
            default:
                Participant::create(['user_id' => $userId]);
        }
    }

    /**
     * Generate Company Ref
     */
    private function getCompanyRef($userId, $companyName)
    {
        $vendor = Company::where('user_id', $userId)->first();

        $timeStamps = match(true){
            strlen($userId) === 1 => substr(time(), -5),
            strlen($userId) === 2 => substr(time(), -4),
            strlen($userId) === 3 => substr(time(), -3),
            strlen($userId) === 4 => substr(time(), -2),
            default => substr(time(), -1),
        }; 
        
        return strtoupper('COM' . $userId . $timeStamps);
    }
}