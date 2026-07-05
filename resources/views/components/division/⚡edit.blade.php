<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Division;
use App\Livewire\Forms\DivisionForm;

new class extends Component
{
    public DivisionForm $form;

    #[On('edit-division')]
    public function editDivision($division_id)
    {
        $division = Division::find($division_id);
        $this->form->setDivision($division);
        Flux::modal('edit-division')->show();
    }

    public function updateDivision()
    {
        $this->form->update();
        Flux::modal('edit-division')->close();
        session()->flash('success', 'Division updated successfully');
        $this->redirectRoute('division.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        // $id di sini dikirim dari index ({id: ...}) yang berisi division_id
        $division = Division::find($id);
        $this->form->setDivision($division);
        Flux::modal('delete-division')->show();
    }

    public function deleteDivision()
    {
        $this->form->division->delete();
        Flux::modal('delete-division')->close();
        session()->flash('success', 'Division deleted successfully');
        $this->redirectRoute('division.index', navigate: true);
    }
};
?>

<div>
    {{-- edit modal --}}
    <flux:modal
        name="edit-division"
        class="md:w-150"
        x-on:close="$wire.resetForm()"
    >
        <form class="space-y-8" wire:submit.prevent="updateDivision">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Division
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Edit your division details below
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:input
                    label="Name"
                    placeholder="Enter division name"
                    wire:model="form.name"
                    wire:dirty.class.text-red-500
                />

                <flux:textarea
                    label="Description"
                    placeholder="Enter division description"
                    wire:model="form.description"
                    wire:dirty.class.text-red-500
                />
            </div>

            <div
                wire:show="$dirty"
                class="text-red-500 dark:text-red-400"
            >
                you have unsaved changes
            </div>

            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- delete modal --}}
    <flux:modal
        name="delete-division"
        class="md:w-150"
        x-on:close="$wire.resetForm()"
    >
        <form class="space-y-8" wire:submit.prevent="deleteDivision">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Delete Division
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    this action cannot be undone
                </flux:text>
            </div>

            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
