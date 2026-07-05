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

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Agenda Program</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage program agendas and schedules</flux:subheading>
    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-agenda">
        <flux:button variant="primary" icon="plus" color="primary">Add Agenda</flux:button>
    </flux:modal.trigger>

    <livewire:agenda.create />
    <livewire:agenda.edit />

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-zinc-900 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
       <flux:table :paginate="$this->agendas">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Agenda Name</flux:table.column>
                <flux:table.column>Program Kerja</flux:table.column>
                <flux:table.column>Execution Date</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->agendas as $agenda)
                    <flux:table.row :key="$agenda->agenda_id">
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->agendas->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-medium text-zinc-900 dark:text-white">
                            {{ $agenda->agenda_name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $agenda->program?->title ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            {{ $agenda->agenda_date ? $agenda->agenda_date->format('d M Y, H:i') : '-' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm" inset="top bottom">{{ $agenda->status }}</flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $agenda->agenda_id }})">Edit</flux:menu.item>
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
