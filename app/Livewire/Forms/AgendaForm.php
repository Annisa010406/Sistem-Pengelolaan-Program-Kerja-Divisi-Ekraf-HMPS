<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Agenda;

class AgendaForm extends Form
{
    public ?Agenda $agenda = null;

    public string $program_id = '';
    public string $agenda_name = '';
    public string $agenda_date = '';
    public string $status = '';

    public function rules(): array
    {
        return [
            'program_id' => ['required', 'exists:programs,program_id'],
            'agenda_name' => ['required', 'string', 'min:3', 'max:255'],
            'agenda_date' => ['required', 'date'],
            'status' => ['required', 'string', 'max:50'],
        ];
    }

    public function store()
    {
        $this->validate();

        Agenda::create($this->all());

        $this->reset();
    }

    public function setAgenda(Agenda $agenda): void
    {
        $this->agenda = $agenda;
        $this->program_id = $agenda->program_id;
        $this->agenda_name = $agenda->agenda_name;
        // Format datetime-local untuk input HTML5
        $this->agenda_date = $agenda->agenda_date ? $agenda->agenda_date->format('Y-m-d\TH:i') : '';
        $this->status = $agenda->status;
    }

    public function update()
    {
        $this->validate();

        $this->agenda->update($this->all());
    }
}
