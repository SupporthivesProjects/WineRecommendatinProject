<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreDashboardController extends Controller
{
    public function index()
    {
        return view('store-manager.storedashboard');
    }
}
