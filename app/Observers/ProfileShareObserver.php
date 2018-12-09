<?php

namespace App\Observers;

use App\Models\ProfileShare;

class ProfileShareObserver
{
    /**
     * Converts the status to string before updating
     *
     * @return App\Models\ProfileShare
     * @author Joseph Owonvwon
     **/
    public function updating(ProfileShare $profileShare)
    {
        $profileShare->status = (string) $profileShare->status;

        return $profileShare;
    }
}
