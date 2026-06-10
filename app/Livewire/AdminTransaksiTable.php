<?php

namespace App\Livewire;

use App\Models\Transaksi;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminTransaksiTable extends Component
{
    use WithPagination;

    public string $status = '';

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $transaksi = Transaksi::with(['user', 'petugas'])
            ->when($this->status !== '', fn ($query) => $query->where('status_pengiriman', $this->status))
            ->latest()
            ->paginate(10);

        $petugas = User::where('role', User::ROLE_PETUGAS)->orderBy('name')->get();

        return view('livewire.admin-transaksi-table', compact('transaksi', 'petugas'));
    }
}
