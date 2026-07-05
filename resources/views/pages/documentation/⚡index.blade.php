<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Documentation;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function documentations()
    {
        return Documentation::with('program')->latest('documentation_id')->paginate(10);
    }

    public function edit($documentation_id)
    {
        $this->dispatch('edit-documentation', documentation_id: $documentation_id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Dokumentasi Program</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage work program files and documentations</flux:subheading>
    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-documentation">
        <flux:button variant="primary" icon="plus" color="primary">Add Documentation</flux:button>
    </flux:modal.trigger>

    <livewire:documentation.create />
    <livewire:documentation.edit />

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-zinc-900 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
       <flux:table :paginate="$this->documentations">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Program Kerja</flux:table.column>
                <flux:table.column>File</flux:table.column>
                <flux:table.column>Description</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->documentations as $doc)
                    <flux:table.row :key="$doc->documentation_id">
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->documentations->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-medium text-zinc-900 dark:text-white">
                            {{ $doc->program?->title ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-blue-600 hover:underline inline-flex items-center gap-1 text-sm">
                                <flux:icon icon="document-text" size="sm" /> View File
                            </a>
                        </flux:table.cell>

                        <flux:table.cell class="text-zinc-500">
                            {{ $doc->description ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $doc->documentation_id }})">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $doc->documentation_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>
