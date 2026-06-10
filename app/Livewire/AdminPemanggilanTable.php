<?php

namespace App\Livewire;

use App\Models\Pemanggilan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPemanggilanTable extends Component
{
    use WithPagination;

    public string $status = '';

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $pemanggilan = Pemanggilan::with(['user', 'petugas'])
            ->when($this->status !== '', fn ($query) => $query->where('status', $this->status))
            ->latest()
            ->paginate(10);

        $petugas = User::where('role', User::ROLE_PETUGAS)->orderBy('name')->get();

        return view('livewire.admin-pemanggilan-table', compact('pemanggilan', 'petugas'));
    }
}
