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

<div class="max-w-7xl mx-auto space-y-5 p-6 bg-pink-50/20 rounded-2xl border border-pink-100/50">
    <!-- Header Aksen Pink -->
    <div>
        <flux:heading size="xl" class="text-pink-900 dark:text-pink-100 font-bold">Program Kerja</flux:heading>
        <flux:subheading size="lg" class="text-pink-600 dark:text-pink-400 font-medium">Manage your work programs</flux:subheading>
    </div>
    <flux:separator variant="subtle" class="bg-pink-100 dark:bg-pink-950" />

    <!-- Tombol Add Program dengan Tema Pink -->
    <flux:modal.trigger name="create-program">
        <flux:button variant="primary" icon="plus" color="pink" class="shadow-sm shadow-pink-200">Add Program</flux:button>
    </flux:modal.trigger>

    <livewire:program.create />
    <livewire:program.edit />

    <!-- Alert Sukses Aksen Pink -->
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-pink-800 rounded-xl bg-pink-100/80 border border-pink-200 dark:bg-pink-950 dark:text-pink-300 font-medium">
            💖 {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Utama dengan Custom Class Pink --}}
    <div class="overflow-x-auto rounded-xl border border-pink-100 bg-white dark:bg-zinc-900 p-2 shadow-sm shadow-pink-50">
       <flux:table :paginate="$this->programs">
            <flux:table.columns>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">No</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Title</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Pic / User</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Timeline</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Status</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->programs as $program)
                    {{-- Row Tabel dengan Hover Effect Pink Lembut --}}
                    <flux:table.row :key="$program->program_id" class="hover:bg-pink-50/30 transition-colors">

                        <flux:table.cell class="text-pink-900/70 font-medium">
                            {{ $loop->iteration + ($this->programs->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-semibold text-pink-950 dark:text-pink-200">
                            {{ $program->title }}
                        </flux:table.cell>

                        <flux:table.cell class="text-pink-700/80 dark:text-pink-300/80">
                            {{ $program->user?->name ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap text-xs text-pink-600/70">
                            {{ \Illuminate\Support\Carbon::parse($program->start_date)->format('d M Y') }} - {{ \Illuminate\Support\Carbon::parse($program->end_date)->format('d M Y') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{-- Badge Dinamis: Jika Selesai otomatis Pink, jika lainnya menggunakan warna default/amber --}}
                            @if($program->status == 'Selesai')
                                <flux:badge size="sm" inset="top bottom" color="pink" class="font-bold shadow-sm shadow-pink-100/50">{{ $program->status }}</flux:badge>
                            @else
                                <flux:badge size="sm" inset="top bottom" color="amber" class="font-bold">{{ $program->status }}</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                {{-- Kustomisasi Tombol Ellipsis Dropdown dengan Warna Pink --}}
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" class="text-pink-400 hover:text-pink-600 hover:bg-pink-50"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $program->program_id }})" class="hover:text-pink-600">Edit</flux:menu.item>
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
