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

<div class="max-w-7xl mx-auto space-y-5 p-6 bg-pink-50/20 rounded-2xl border border-pink-100/50">
    <!-- Header dengan Aksen Teks Pink -->
    <div>
        <flux:heading size="xl" class="text-pink-900 dark:text-pink-100 font-bold">Dokumentasi Program</flux:heading>
        <flux:subheading size="lg" class="text-pink-600 dark:text-pink-400 font-medium">Manage work program files and documentations</flux:subheading>
    </div>
    
    <flux:separator variant="subtle" class="bg-pink-100 dark:bg-pink-950" />

    <!-- Tombol Add Documentation dengan Tema Pink -->
    <flux:modal.trigger name="create-documentation">
        <flux:button variant="primary" icon="plus" color="pink" class="shadow-sm shadow-pink-200">Add Documentation</flux:button>
    </flux:modal.trigger>

    <livewire:documentation.create />
    <livewire:documentation.edit />

    <!-- Alert Sukses Aksen Pink -->
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-pink-800 rounded-xl bg-pink-100/80 border border-pink-200 dark:bg-pink-950 dark:text-pink-300 font-medium">
            💖 {{ session('success') }}
        </div>
    @endif

    {{-- Struktur Tabel Dengan Custom Styling Pink --}}
    <div class="overflow-x-auto rounded-xl border border-pink-100 bg-white dark:bg-zinc-900 p-2 shadow-sm shadow-pink-50">
       <flux:table :paginate="$this->documentations">
            <flux:table.columns>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">No</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Program Kerja</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">File</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Description</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->documentations as $doc)
                    {{-- Row dengan efek hover pink tipis --}}
                    <flux:table.row :key="$doc->documentation_id" class="hover:bg-pink-50/30 transition-colors">
                        
                        <flux:table.cell class="text-pink-900/70 font-medium">
                            {{ $loop->iteration + ($this->documentations->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-semibold text-pink-950 dark:text-pink-200">
                            {{ $doc->program?->title ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{-- Link View File diubah ke Pink Cerah --}}
                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-pink-600 hover:text-pink-700 font-medium hover:underline inline-flex items-center gap-1.5 text-sm transition-colors">
                                <flux:icon icon="document-text" size="sm" class="text-pink-400" /> View File
                            </a>
                        </flux:table.cell>

                        <flux:table.cell class="text-pink-700/80 dark:text-pink-300/80 max-w-xs truncate">
                            {{ $doc->description ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                {{-- Tombol Ellipsis Dropdown dengan Warna Pink --}}
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" class="text-pink-400 hover:text-pink-600 hover:bg-pink-50"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $doc->documentation_id }})" class="hover:text-pink-600">Edit</flux:menu.item>
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