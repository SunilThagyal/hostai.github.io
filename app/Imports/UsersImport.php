<?php
namespace App\Imports;

use App\Models\Contractor;
use App\Models\User;
use App\Models\Worker;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Validation\ValidationException;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            // @dd(request()->has('workerof'));
            $UserID =request()->has('workerof') ? Request('workerof') : Auth::user()->id;
            $worker = config('constants.worker');
            $user= User::create([
                'first_name' => $row['name'],
                'role' => $worker,
                // 'password' => Hash::make($row['password']),
            ]);
    
            //worker table
            $worker = [
                'user_id' => $user->id,
                'contractor_id' => $UserID,
                'manager_id' => get_parent_manager(),
            ];
    
            Worker::create($worker);
    
            // return [
            //     'status' => true,
            //     'message' => 'inserted'
            // ];
        } catch(\Exception $e) {
            $error = 'An error occurred while importing the CSV file. Please make sure the file is in the correct format.';
            throw ValidationException::withMessages([$error, $e->getMessage()]);
        }
    }
    
}
