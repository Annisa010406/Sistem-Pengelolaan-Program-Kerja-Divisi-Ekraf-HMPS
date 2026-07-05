<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\DocumentationForm;
use App\Models\Program;
use Livewire\Attributes\Computed;

new class extends Component
{
    use WithFileUploads;

    public DocumentationForm $form;

    #[Computed]
    public function programs()
    {
        return Program::all();
    }

    public function save()
    {
        $this->form->store();
        Flux::modal('create-documentation')->close();

        session()->flash('success', 'Documentation saved successfully');
        $this->redirectRoute('documentation.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-documentation" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg">Upload Documentation</flux:heading>
                <flux:text>Attach file documentation or reports for work programs</flux:text>
            </div>

            <div class="space-y-4">
                {{-- Select Program --}}
                <flux:select label="Program Kerja" wire:model="form.program_id" placeholder="Choose Program...">
                    @foreach($this->programs as $program)
                        <flux:select.option value="{{ $program->program_id }}">{{ $program->title }}</flux:select.option>
                    @endforeach
                </flux:select>

                {{-- File Input --}}
                <flux:input type="file" label="File Attachment" wire:model="form.file" />

                {{-- Description Input --}}
                <flux:input label="Description" placeholder="Enter brief file description" wire:model="form.description" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">Upload</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
