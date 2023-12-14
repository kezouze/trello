<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(){
        return response()->json([
            'card' => Card::orderBy('position', 'ASC')->get()
        ]);
    }

    public function orderCardUpdate(Request $request) {
        $cards = $request->get('cards');
        foreach($cards as $card) {
            $cards = Card::find($cards['id']);
            $cards->position = $cards['position'];
            $cards->save();
        } 
        return response()->json([
            'cards' => Card::with('cards')->orderBy('position', 'ASC')
        ]);
    }
    public function get_card(Card $card) {
        return response()->json([
            'card' => $card
        ]);
    }
}