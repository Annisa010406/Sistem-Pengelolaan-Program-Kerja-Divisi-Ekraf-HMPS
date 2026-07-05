<?php

use Livewire\Component;
use App\Livewire\Forms\ReportForm;
use App\Models\Program;
use Livewire\Attributes\Computed;

new class extends Component
{
    public ReportForm $form;

    #[Computed]
    public function programs()
    {
        return Program::all();
    }

    public function save()
    {
        $this->form->store();
        Flux::modal('create-report')->close();

        session()->flash('success', 'Report submitted successfully');
        $this->redirectRoute('report.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-report" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg">Submit Final Report</flux:heading>
                <flux:text>Write down the final outcome or result description for the program</flux:text>
            </div>

            <div class="space-y-4">
                {{-- Select Program --}}
                <flux:select label="Program Kerja" wire:model="form.program_id" placeholder="Choose Program...">
                    @foreach($this->programs as $program)
                        <flux:select.option value="{{ $program->program_id }}">{{ $program->title }}</flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Result Textarea --}}
                <flux:textarea label="Result / Summary Outcome" placeholder="Describe the program summary, key metrics, or final result..." wire:model="form.result" rows="5" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">Submit Report</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
