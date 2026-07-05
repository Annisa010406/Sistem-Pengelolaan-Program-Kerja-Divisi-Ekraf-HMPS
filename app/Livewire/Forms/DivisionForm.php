<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Division;
use Illuminate\Validation\Rule;

class DivisionForm extends Form
{
    public string $name = '';
    public string $description = '';
    public ?Division $division = null;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                // Mengabaikan division_id milik data ini sendiri saat update data unik
                Rule::unique('divisions', 'name')->ignore($this->division?->division_id, 'division_id'),
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function store()
    {
        $this->validate();

        Division::create($this->only(['name', 'description']));

        $this->reset();
    }

    public function setDivision(Division $division): void
    {
        $this->division = $division;
        $this->name = $division->name;
        $this->description = $division->description ?? '';
    }

    public function update()
    {
        $this->validate();

        $this->division->update($this->only(['name', 'description']));
    }
}
