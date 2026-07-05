<?php

use Livewire\Component;
use App\Livewire\Forms\AgendaForm;
use App\Models\Program;
use Livewire\Attributes\Computed;

new class extends Component
{
    public AgendaForm $form;

    #[Computed]
    public function programs()
    {
        return Program::all();
    }

    public function save()
    {
        $this->form->store();
        Flux::modal('create-agenda')->close();

        session()->flash('success', 'Agenda created successfully');
        $this->redirectRoute('agenda.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-agenda" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg">Create Agenda</flux:heading>
                <flux:text>Schedule a sub-agenda or activity timeline</flux:text>
            </div>

            <div class="space-y-4">
                {{-- Select Relasi Program --}}
                <flux:select label="Program Kerja" wire:model="form.program_id" placeholder="Choose Program...">
                    @foreach($this->programs as $program)
                        <flux:select.option value="{{ $program->program_id }}">{{ $program->title }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Agenda Name" placeholder="Enter agenda activity name" wire:model="form.agenda_name" />

                <flux:input type="datetime-local" label="Agenda Date & Time" wire:model="form.agenda_date" />

                <flux:select label="Status" wire:model="form.status" placeholder="Select status...">
                    <flux:select.option value="Pending">Pending</flux:select.option>
                    <flux:select.option value="Ongoing">Ongoing</flux:select.option>
                    <flux:select.option value="Done">Done</flux:select.option>
                </flux:select>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">Create</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
