<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

class AccountList extends Component
{
    use WithPagination;
    public function render()
    {
        $accounts = Account::paginate(10);
        return view('livewire.account-list',['accounts' => $accounts]);
    }
}
