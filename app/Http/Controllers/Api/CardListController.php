<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CardList;
use Illuminate\Http\Request;

class CardListController extends Controller
{
    public function index(){
        return response()->json([
            'card_list' => CardList::all()
        ]);
    }
}
