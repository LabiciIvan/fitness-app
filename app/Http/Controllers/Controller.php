<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    public ?User $user = null;
 
    public function __construct() {
        $this->user = Auth::user();
    }
}
