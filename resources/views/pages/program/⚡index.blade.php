<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Program;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function programs()
    {
        // Memuat relasi user agar bisa menampilkan nama pembuat program
        return Program::with('user')->latest('program_id')->paginate(10);
    }

    public function edit($program_id)
    {
        $this->dispatch('edit-program', program_id: $program_id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Program Kerja</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage your work programs</flux:subheading>
    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-program">
        <flux:button variant="primary" icon="plus" color="primary">Add Program</flux:button>
    </flux:modal.trigger>

    <livewire:program.create />
    <livewire:program.edit />

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-zinc-900 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
       <flux:table :paginate="$this->programs">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Pic / User</flux:table.column>
                <flux:table.column>Timeline</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->programs as $program)
                    <flux:table.row :key="$program->program_id">
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->programs->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-medium text-zinc-900 dark:text-white">
                            {{ $program->title }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $program->user?->name ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap text-xs text-zinc-500">
                            {{ \Illuminate\Support\Carbon::parse($program->start_date)->format('d M Y') }} - {{ \Illuminate\Support\Carbon::parse($program->end_date)->format('d M Y') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm" inset="top bottom">{{ $program->status }}</flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $program->program_id }})">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $program->program_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>
