<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Models\Documentation;
use App\Models\Program;
use App\Livewire\Forms\DocumentationForm;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    use WithFileUploads;

    public DocumentationForm $form;

    #[Computed]
    public function programs()
    {
        return Program::all();
    }

    #[On('edit-documentation')]
    public function editDocumentation($documentation_id)
    {
        $documentation = Documentation::find($documentation_id);
        $this->form->setDocumentation($documentation);
        Flux::modal('edit-documentation')->show();
    }

    public function updateDocumentation()
    {
        $this->form->update();
        Flux::modal('edit-documentation')->close();
        session()->flash('success', 'Documentation updated successfully');
        $this->redirectRoute('documentation.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $documentation = Documentation::find($id);
        $this->form->setDocumentation($documentation);
        Flux::modal('delete-documentation')->show();
    }

    public function deleteDocumentation()
    {
        // Hapus file fisik dari storage disk
        if ($this->form->documentation->file_path) {
            Storage::disk('public')->delete($this->form->documentation->file_path);
        }

        $this->form->documentation->delete();
        Flux::modal('delete-documentation')->close();

        session()->flash('success', 'Documentation deleted successfully');
        $this->redirectRoute('documentation.index', navigate: true);
    }
};
?>

<div>
    {{-- edit modal --}}
    <flux:modal name="edit-documentation" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="updateDocumentation">
            <div class="space-y-2">
                <flux:heading size="lg">Edit Documentation</flux:heading>
                <flux:text>Modify or replace documentation details</flux:text>
            </div>

            <div class="space-y-4">
                <flux:select label="Program Kerja" wire:model="form.program_id">
                    @foreach($this->programs as $program)
                        <flux:select.option value="{{ $program->program_id }}">{{ $program->title }}</flux:select.option>
                    @endforeach
                </flux:select>

                <div>
                    <flux:input type="file" label="Replace File Attachment (Optional)" wire:model="form.file" />
                    <span class="text-xs text-zinc-400 block mt-1">Current file: {{ $form->file_path }}</span>
                </div>

                <flux:input label="Description" wire:model="form.description" />
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
    <flux:modal name="delete-documentation" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="deleteDocumentation">
            <div class="space-y-2">
                <flux:heading size="lg">Delete Documentation</flux:heading>
                <flux:text>This action cannot be undone and will permanently delete the attached file.</flux:text>
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
