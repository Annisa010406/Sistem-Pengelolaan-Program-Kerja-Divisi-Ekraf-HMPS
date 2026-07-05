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

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Laporan Program Kerja</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage program final outcomes and reports</flux:subheading>
    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-report">
        <flux:button variant="primary" icon="plus" color="primary">Add Report</flux:button>
    </flux:modal.trigger>

    <livewire:report.create />
    <livewire:report.edit />

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-zinc-900 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
       <flux:table :paginate="$this->reports">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Program Kerja</flux:table.column>
                <flux:table.column>Report Result Outcome</flux:table.column>
                <flux:table.column>Submitted At</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->reports as $report)
                    <flux:table.row :key="$report->report_id">
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->reports->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-medium text-zinc-900 dark:text-white">
                            {{ $report->program?->title ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell class="max-w-xs truncate text-zinc-600 dark:text-zinc-400">
                            {{ $report->result }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            {{ $report->created_at->format('d M Y, H:i') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $report->report_id }})">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $report->report_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>
