<?php

use Livewire\Component;
use App\Livewire\Forms\DivisionForm;

new class extends Component
{
    // Instance class DivisionForm
    public DivisionForm $form;

    public function save()
    {
        $this->form->store();
        Flux::modal('create-division')->close();

        // session
        session()->flash('success', 'Division created successfully');

        $this->redirectRoute('division.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-division" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Create Division
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Add a new division to your organization
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:input
                    label="Name"
                    placeholder="Enter division name"
                    wire:model="form.name"
                />

                <flux:textarea
                    label="Description"
                    placeholder="Enter division description"
                    wire:model="form.description"
                />
            </div>

            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
