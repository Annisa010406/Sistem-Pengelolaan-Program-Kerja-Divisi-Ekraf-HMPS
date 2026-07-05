<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Program;
use Illuminate\Validation\Rule;

class ProgramForm extends Form
{
    public ?Program $program = null;

    public string $user_id = '';
    public string $title = '';
    public string $description = '';
    public string $start_date = '';
    public string $end_date = '';
    public string $status = '';

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'string', 'max:50'],
        ];
    }

    public function store()
    {
        $this->validate();

        Program::create($this->all());

        $this->reset();
    }

    public function setProgram(Program $program): void
    {
        $this->program = $program;
        $this->user_id = $program->user_id;
        $this->title = $program->title;
        $this->description = $program->description ?? '';
        $this->start_date = $program->start_date;
        $this->end_date = $program->end_date;
        $this->status = $program->status;
    }

    public function update()
    {
        $this->validate();

        $this->program->update($this->all());
    }
}
