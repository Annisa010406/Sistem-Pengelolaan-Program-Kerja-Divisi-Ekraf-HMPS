<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\WithFileUploads;
use App\Models\Documentation;
use Illuminate\Support\Facades\Storage;

class DocumentationForm extends Form
{
    public ?Documentation $documentation = null;

    public string $program_id = '';
    public $file; // Untuk menampung file upload baru
    public string $file_path = '';
    public string $description = '';

    public function rules(): array
    {
        return [
            'program_id' => ['required', 'exists:programs,program_id'],
            'file' => $this->documentation ? ['nullable', 'file', 'max:10240'] : ['required', 'file', 'max:10240'], // Maksimal 10MB
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function store()
    {
        $this->validate();

        // Proses upload file ke folder public/documentations
        $path = $this->file->store('documentations', 'public');

        Documentation::create([
            'program_id' => $this->program_id,
            'file_path' => $path,
            'description' => $this->description,
        ]);

        $this->reset();
    }

    public function setDocumentation(Documentation $documentation): void
    {
        $this->documentation = $documentation;
        $this->program_id = $documentation->program_id;
        $this->file_path = $documentation->file_path;
        $this->description = $documentation->description ?? '';
    }

    public function update()
    {
        $this->validate();

        $data = [
            'program_id' => $this->program_id,
            'description' => $this->description,
        ];

        // Jika ada file baru yang diunggah, ganti file lama
        if ($this->file) {
            if ($this->documentation->file_path) {
                Storage::disk('public')->delete($this->documentation->file_path);
            }
            $data['file_path'] = $this->file->store('documentations', 'public');
        }

        $this->documentation->update($data);
        $this->reset(['file']);
    }
}
