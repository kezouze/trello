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

    public function update(Request $request) {
        if($card = Card::find($request->get('card')['id'])) {
            $card->update([
                'title' => $request->get('card')['title'],
                'description' => $request->get('card')['description']
            ]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}