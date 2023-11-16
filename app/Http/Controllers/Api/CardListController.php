<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CardList;
use Illuminate\Http\Request;

class CardListController extends Controller
{
    public function index(){
        return response()->json([
            'card_list' => CardList::with('cards')->orderBy('position', 'ASC')->get()
        ]);
    }

    public function orderUpdate(Request $request) {
        $card_lists = $request->get('card_lists');
        foreach($card_lists as $card_list) {
            $cardList = CardList::find($card_list['id']);
            $cardList->position = $card_list['position'];
            $cardList->save();
        }
        return response()->json([
            'card_list' => CardList::with('cards')->orderBy('position', 'ASC')->get()
        ]);
    }
}
