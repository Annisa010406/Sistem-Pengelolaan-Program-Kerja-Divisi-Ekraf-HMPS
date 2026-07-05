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

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Division</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage your divisions</flux:subheading>
    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-division">
        <flux:button variant="primary" icon="plus" color="primary">Add Division</flux:button>
    </flux:modal.trigger>

    <livewire:division.create />
    <livewire:division.edit />
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-zinc-850 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif
    {{-- table --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->divisions">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Description</flux:table.column>
                <flux:table.column>Created At</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->divisions as $division)
                    <flux:table.row :key="$division->division_id">

                        <flux:table.cell>
                            {{ $loop->iteration + ($this->divisions->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="flex items-center gap-3">
                            {{ $division->name }}
                        </flux:table.cell>

                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $division->description ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            {{ $division->created_at->diffForHumans() }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $division->division_id }})">Edit</flux:menu.item>

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
