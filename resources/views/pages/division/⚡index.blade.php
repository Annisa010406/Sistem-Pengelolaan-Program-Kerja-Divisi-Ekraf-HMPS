<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Division;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function divisions()
    {
        return Division::latest('division_id')->paginate(10);
    }

    public function edit($division_id)
    {
        $this->dispatch('edit-division', division_id: $division_id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-5 p-6 bg-pink-50/20 rounded-2xl border border-pink-100/50">
    <!-- Header dengan Aksen Teks Pink -->
    <div>
        <flux:heading size="xl" class="text-pink-900 dark:text-pink-100 font-bold">Division</flux:heading>
        <flux:subheading size="lg" class="text-pink-600 dark:text-pink-400 font-medium">Manage your divisions</flux:subheading>
    </div>

    <flux:separator variant="subtle" class="bg-pink-100 dark:bg-pink-950" />

    <!-- Tombol Add Division diubah ke warna Pink melalui attribute color -->
    <flux:modal.trigger name="create-division">
        <flux:button variant="primary" icon="plus" color="pink" class="shadow-sm shadow-pink-200">Add Division</flux:button>
    </flux:modal.trigger>

    <livewire:division.create />
    <livewire:division.edit />

    <!-- Alert Sukses dengan nuansa Pink -->
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-pink-800 rounded-xl bg-pink-100/80 border border-pink-200 dark:bg-pink-950 dark:text-pink-300 font-medium animate-fade-in">
            💖 {{ session('success') }}
        </div>
    @endif

    {{-- Struktur Tabel Dengan Custom Styling Pink --}}
    <div class="overflow-x-auto rounded-xl border border-pink-100 bg-white dark:bg-zinc-900 p-2 shadow-sm shadow-pink-50">
       <flux:table :paginate="$this->divisions">
            <flux:table.columns>
                {{-- Header kolom diberi warna pink pudar --}}
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">No</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Name</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Description</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Created At</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->divisions as $division)
                    {{-- Row dengan efek hover pink tipis --}}
                    <flux:table.row :key="$division->division_id" class="hover:bg-pink-50/30 transition-colors">

                        <flux:table.cell class="text-pink-900/70 font-medium">
                            {{ $loop->iteration + ($this->divisions->firstItem() - 1) }}
                        </flux:table.cell>

                        {{-- Nama divisi dibikin bold pink tua --}}
                        <flux:table.cell class="flex items-center gap-3 font-semibold text-pink-950 dark:text-pink-200">
                            {{ $division->name }}
                        </flux:table.cell>

                        <flux:table.cell class="text-pink-700/80 dark:text-pink-300/80 max-w-xs truncate">
                            {{ $division->description ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap text-pink-600/70 text-xs">
                            {{ $division->created_at->diffForHumans() }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                {{-- Mengubah button trigger dropdown/ellipsis memakai aksen warna pink --}}
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" class="text-pink-400 hover:text-pink-600 hover:bg-pink-50"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $division->division_id }})" class="hover:text-pink-600">Edit</flux:menu.item>

                                    <flux:menu.separator />

                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $division->division_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>
