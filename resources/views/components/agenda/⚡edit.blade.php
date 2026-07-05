<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Models\Agenda;
use App\Models\Program;
use App\Livewire\Forms\AgendaForm;

new class extends Component
{
    public AgendaForm $form;

    #[Computed]
    public function programs()
    {
        return Program::all();
    }

    #[On('edit-agenda')]
    public function editAgenda($agenda_id)
    {
        $agenda = Agenda::find($agenda_id);
        $this->form->setAgenda($agenda);
        Flux::modal('edit-agenda')->show();
    }

    public function updateAgenda()
    {
        $this->form->update();
        Flux::modal('edit-agenda')->close();
        session()->flash('success', 'Agenda updated successfully');
        $this->redirectRoute('agenda.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $agenda = Agenda::find($id);
        $this->form->setAgenda($agenda);
        Flux::modal('delete-agenda')->show();
    }

    public function deleteAgenda()
    {
        $this->form->agenda->delete();
        Flux::modal('delete-agenda')->close();
        session()->flash('success', 'Agenda deleted successfully');
        $this->redirectRoute('agenda.index', navigate: true);
    }
};
?>

<div>
    {{-- edit modal --}}
    <flux:modal name="edit-agenda" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="updateAgenda">
            <div class="space-y-2">
                <flux:heading size="lg">Edit Agenda</flux:heading>
                <flux:text>Modify agenda schedules and status</flux:text>
            </div>

            <div class="space-y-4">
                <flux:select label="Program Kerja" wire:model="form.program_id">
                    @foreach($this->programs as $program)
                        <flux:select.option value="{{ $program->program_id }}">{{ $program->title }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Agenda Name" wire:model="form.agenda_name" />

                <flux:input type="datetime-local" label="Agenda Date & Time" wire:model="form.agenda_date" />

                <flux:select label="Status" wire:model="form.status">
                    <flux:select.option value="Pending">Pending</flux:select.option>
                    <flux:select.option value="Ongoing">Ongoing</flux:select.option>
                    <flux:select.option value="Done">Done</flux:select.option>
                </flux:select>
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
    <flux:modal name="delete-agenda" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="deleteAgenda">
            <div class="space-y-2">
                <flux:heading size="lg">Delete Agenda</flux:heading>
                <flux:text>This action cannot be undone.</flux:text>
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
