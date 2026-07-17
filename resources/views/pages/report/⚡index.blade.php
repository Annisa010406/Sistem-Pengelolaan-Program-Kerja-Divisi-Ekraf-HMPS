<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Report;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function reports()
    {
        return Report::with('program')->latest('report_id')->paginate(10);
    }

    public function edit($report_id)
    {
        $this->dispatch('edit-report', report_id: $report_id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-5 p-6 bg-pink-50/20 rounded-2xl border border-pink-100/50">
    <!-- Header Aksen Pink -->
    <div>
        <flux:heading size="xl" class="text-pink-900 dark:text-pink-100 font-bold">Laporan Program Kerja</flux:heading>
        <flux:subheading size="lg" class="text-pink-600 dark:text-pink-400 font-medium">Manage program final outcomes and reports</flux:subheading>
    </div>
    
    <flux:separator variant="subtle" class="bg-pink-100 dark:bg-pink-950" />

    <!-- Tombol Add Report dengan Tema Pink Bawaan Flux UI -->
    <flux:modal.trigger name="create-report">
        <flux:button variant="primary" icon="plus" color="pink" class="shadow-sm shadow-pink-200">Add Report</flux:button>
    </flux:modal.trigger>

    <livewire:report.create />
    <livewire:report.edit />

    <!-- Alert Sukses Nuansa Pink -->
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-pink-800 rounded-xl bg-pink-100/80 border border-pink-200 dark:bg-pink-950 dark:text-pink-300 font-medium">
            💖 {{ session('success') }}
        </div>
    @endif

    {{-- Kustomisasi Tabel dengan Sentuhan Pink Menarik --}}
    <div class="overflow-x-auto rounded-xl border border-pink-100 bg-white dark:bg-zinc-900 p-2 shadow-sm shadow-pink-50">
       <flux:table :paginate="$this->reports">
            <flux:table.columns>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">No</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Program Kerja</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Report Result Outcome</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Submitted At</flux:table.column>
                <flux:table.column class="text-pink-500 font-semibold text-xs uppercase tracking-wider">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->reports as $report)
                    {{-- Row Tabel dengan Efek Hover Pink Transparan --}}
                    <flux:table.row :key="$report->report_id" class="hover:bg-pink-50/30 transition-colors">
                        
                        <flux:table.cell class="text-pink-900/70 font-medium">
                            {{ $loop->iteration + ($this->reports->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-semibold text-pink-950 dark:text-pink-200">
                            {{ $report->program?->title ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell class="max-w-xs truncate text-pink-700/80 dark:text-pink-300/80">
                            {{ $report->result }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap text-xs text-pink-600/70">
                            {{ $report->created_at->format('d M Y, H:i') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                {{-- Tombol Ellipsis Menggunakan Aksen Warna Pink --}}
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" class="text-pink-400 hover:text-pink-600 hover:bg-pink-50"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $report->report_id }})" class="hover:text-pink-600">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $report->report_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>