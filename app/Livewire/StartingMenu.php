<?php

namespace App\Livewire;

use Closure;
use Livewire\Attributes\Layout;
use Livewire\Component;

class StartingMenu extends Component
{
    public function render()
    {
        $icons = [
            'admin' => 'heroicon-m-users',
            'publication' => 'heroicon-m-document-text',
            'finalProject' =>'phosphor-article-fill',
        ];
        $panels = filament()->getPanels();
        $labels = [
            'publication' => 'Publikasi',
            'finalProject' => 'Tugas Akhir',
        ];
        return view('livewire.starting-menu', [
            "panels" => $panels,
            "icons" => $icons,
            "labels" => $labels
        ]);
    }
}
