<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Models\Program;
use App\Models\User;
use App\Livewire\Forms\ProgramForm;

new class extends Component
{
    public ProgramForm $form;

    #[Computed]
    public function users()
    {
        return User::all();
    }

    #[On('edit-program')]
    public function editProgram($program_id)
    {
        $program = Program::find($program_id);
        $this->form->setProgram($program);
        Flux::modal('edit-program')->show();
    }

    public function updateProgram()
    {
        $this->form->update();
        Flux::modal('edit-program')->close();
        session()->flash('success', 'Program updated successfully');
        $this->redirectRoute('program.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $program = Program::find($id);
        $this->form->setProgram($program);
        Flux::modal('delete-program')->show();
    }

    public function deleteProgram()
    {
        $this->form->program->delete();
        Flux::modal('delete-program')->close();
        session()->flash('success', 'Program deleted successfully');
        $this->redirectRoute('program.index', navigate: true);
    }
};
?>

<div>
    {{-- edit modal --}}
    <flux:modal name="edit-program" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="updateProgram">
            <div class="space-y-2">
                <flux:heading size="lg">Edit Program</flux:heading>
                <flux:text>Modify work program details below</flux:text>
            </div>

            <div class="space-y-4">
                <flux:select label="Assign To (User)" wire:model="form.user_id">
                    @foreach($this->users as $user)
                        <flux:select.option value="{{ $user->id }}">{{ $user->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Title" wire:model="form.title" />
                <flux:textarea label="Description" wire:model="form.description" />

                <div class="grid grid-cols-2 gap-4">
                    <flux:input type="date" label="Start Date" wire:model="form.start_date" />
                    <flux:input type="date" label="End Date" wire:model="form.end_date" />
                </div>

                <flux:select label="Status" wire:model="form.status">
                    <flux:select.option value="Planned">Planned</flux:select.option>
                    <flux:select.option value="In Progress">In Progress</flux:select.option>
                    <flux:select.option value="Completed">Completed</flux:select.option>
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
    <flux:modal name="delete-program" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="deleteProgram">
            <div class="space-y-2">
                <flux:heading size="lg">Delete Program</flux:heading>
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
