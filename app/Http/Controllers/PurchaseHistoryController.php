<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseResource;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $purchases = $user->purchases()->with('items')->latest()->get();

        return PurchaseResource::collection($purchases);
    }
}
