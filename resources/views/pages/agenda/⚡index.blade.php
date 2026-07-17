<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Agenda;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function agendas()
    {
        return Agenda::with('program')->latest('agenda_id')->paginate(10);
    }

    public function edit($agenda_id)
    {
        $this->dispatch('edit-agenda', agenda_id: $agenda_id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-5 p-6 bg-pink-50/20 rounded-2xl border border-pink-100/50">
    <!-- Header Aksen Pink -->
    <div>
        <flux:heading size="xl" class="text-pink-900 dark:text-pink-100 font-bold">Agenda Program</flux:heading>
        <flux:subheading size="lg" class="text-pink-600 dark:text-pink-400 font-medium">Manage program agendas and schedules</flux:subheading>
    </div>
    <flux:separator variant="subtle" class="bg-pink-100 dark:bg-pink-950" />

    <!-- Tombol Add Agenda Tema Pink -->
    <flux:modal.trigger name="create-agenda">
        <flux:button variant="primary" icon="plus" color="pink" class="shadow-sm shadow-pink-200">Add Agenda</flux:button>
    </flux:modal.trigger>

    <livewire:agenda.create />
    <livewire:agenda.edit />

    <!-- Alert Sukses dengan nuansa Pink -->
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-pink-800 rounded-xl bg-pink-100/80 border border-pink-200 dark:bg-pink-950 dark:text-pink-300 font-medium">
            💖 {{ session('success') }}
        </div>
    @endif

    {{-- Kustomisasi Tabel dengan Sentuhan Pink Menarik --}}
    <div class="overflow-x-auto rounded-xl border border-pink-100 bg-white dark:bg-zinc-900 p-2 shadow-sm shadow-pink-50">
       <flux:table :paginate="$this->agendas">
            <flux:table.columns>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">No</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Agenda Name</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Program Kerja</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Execution Date</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Status</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->agendas as $agenda)
                    {{-- Efek Hover Pink Lembut pada Baris Tabel --}}
                    <flux:table.row :key="$agenda->agenda_id" class="hover:bg-pink-50/30 transition-colors">
                        
                        <flux:table.cell class="text-pink-900/70 font-medium">
                            {{ $loop->iteration + ($this->agendas->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-semibold text-pink-950 dark:text-pink-200">
                            {{ $agenda->agenda_name }}
                        </flux:table.cell>

                        <flux:table.cell class="text-pink-700/80 dark:text-pink-300/80">
                            {{ $agenda->program?->title ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap text-xs text-pink-600/70">
                            {{ $agenda->agenda_date ? $agenda->agenda_date->format('d M Y, H:i') : '-' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{-- Badge Status Dinamis (Pink jika Selesai / Terlaksana) --}}
                            @if(in_array($agenda->status, ['Selesai', 'Terlaksana']))
                                <flux:badge size="sm" inset="top bottom" color="pink" class="font-bold shadow-sm shadow-pink-100/50">{{ $agenda->status }}</flux:badge>
                            @else
                                <flux:badge size="sm" inset="top bottom" color="amber" class="font-bold">{{ $agenda->status }}</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                {{-- Tombol Ellipsis Menggunakan Aksen Pink --}}
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" class="text-pink-400 hover:text-pink-600 hover:bg-pink-50"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $agenda->agenda_id }})" class="hover:text-pink-600">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $agenda->agenda_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>