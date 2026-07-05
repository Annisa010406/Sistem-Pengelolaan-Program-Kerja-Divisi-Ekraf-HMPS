<?php

use Livewire\Component;
use App\Livewire\Forms\ProgramForm;
use App\Models\User;
use Livewire\Attributes\Computed;

new class extends Component
{
    public ProgramForm $form;

    #[Computed]
    public function users()
    {
        return User::all();
    }

    public function save()
    {
        $this->form->store();
        Flux::modal('create-program')->close();

        session()->flash('success', 'Program created successfully');
        $this->redirectRoute('program.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-program" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg">Create Program</flux:heading>
                <flux:text>Add a new work program details</flux:text>
            </div>

            <div class="space-y-4">
                {{-- Select PIC User --}}
                <flux:select label="Assign To (User)" wire:model="form.user_id" placeholder="Choose User...">
                    @foreach($this->users as $user)
                        <flux:select.option value="{{ $user->id }}">{{ $user->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Title" placeholder="Enter program title" wire:model="form.title" />

                <flux:textarea label="Description" placeholder="Enter program description" wire:model="form.description" />

                <div class="grid grid-cols-2 gap-4">
                    <flux:input type="date" label="Start Date" wire:model="form.start_date" />
                    <flux:input type="date" label="End Date" wire:model="form.end_date" />
                </div>

                <flux:select label="Status" wire:model="form.status" placeholder="Select status...">
                    <flux:select.option value="Planned">Planned</flux:select.option>
                    <flux:select.option value="In Progress">In Progress</flux:select.option>
                    <flux:select.option value="Completed">Completed</flux:select.option>
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
