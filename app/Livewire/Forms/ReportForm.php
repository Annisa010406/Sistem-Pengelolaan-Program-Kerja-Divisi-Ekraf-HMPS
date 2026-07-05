<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Report;

class ReportForm extends Form
{
    public ?Report $report = null;

    public string $program_id = '';
    public string $result = '';

    public function rules(): array
    {
        return [
            'program_id' => ['required', 'exists:programs,program_id'],
            'result' => ['required', 'string', 'min:5'],
        ];
    }

    public function store()
    {
        $this->validate();

        Report::create($this->all());

        $this->reset();
    }

    public function setReport(Report $report): void
    {
        $this->report = $report;
        $this->program_id = $report->program_id;
        $this->result = $report->result;
    }

    public function update()
    {
        $this->validate();

        $this->report->update($this->all());
    }
}
