<?php

namespace App\Livewire;

use Livewire\Component;

class FotoUpload extends Component
{
    public $inputs = [];

    public function addInput()
    {
        $this->inputs[] = count($this->inputs);
    }

    public function removeInput($index)
    {
        unset($this->inputs[$index]);
        $this->inputs = array_values($this->inputs);
    }

    public function render()
    {
        return view('livewire.foto-upload');
    }
}
