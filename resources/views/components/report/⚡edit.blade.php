<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Models\Report;
use App\Models\Program;
use App\Livewire\Forms\ReportForm;

new class extends Component
{
    public ReportForm $form;

    #[Computed]
    public function programs()
    {
        return Program::all();
    }

    #[On('edit-report')]
    public function editReport($report_id)
    {
        $report = Report::find($report_id);
        $this->form->setReport($report);
        Flux::modal('edit-report')->show();
    }

    public function updateReport()
    {
        $this->form->update();
        Flux::modal('edit-report')->close();
        session()->flash('success', 'Report updated successfully');
        $this->redirectRoute('report.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $report = Report::find($id);
        $this->form->setReport($report);
        Flux::modal('delete-report')->show();
    }

    public function deleteReport()
    {
        $this->form->report->delete();
        Flux::modal('delete-report')->close();
        session()->flash('success', 'Report deleted successfully');
        $this->redirectRoute('report.index', navigate: true);
    }
};
?>

<div>
    {{-- edit modal --}}
    <flux:modal name="edit-report" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="updateReport">
            <div class="space-y-2">
                <flux:heading size="lg">Edit Report</flux:heading>
                <flux:text>Update the summary or final results data</flux:text>
            </div>

            <div class="space-y-4">
                <flux:select label="Program Kerja" wire:model="form.program_id">
                    @foreach($this->programs as $program)
                        <flux:select.option value="{{ $program->program_id }}">{{ $program->title }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:textarea label="Result / Summary Outcome" wire:model="form.result" rows="5" />
            </div>

            <div wire:show="$dirty" class="text-red-500 dark:text-red-400 text-sm">
                you have unsaved changes
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- delete modal --}}
    <flux:modal name="delete-report" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="deleteReport">
            <div class="space-y-2">
                <flux:heading size="lg">Delete Report</flux:heading>
                <flux:text>Are you sure you want to delete this report summary? This action cannot be reverted.</flux:text>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
