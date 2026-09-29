<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $busqueda = '';
    public $rol = '';
    public $verificado = '';

    public function updatedBusqueda()
    {
        $this->resetPage();
    }

    public function updatedRol()
    {
        $this->resetPage();
    }

    public function updatedVerificado()
    {
        $this->resetPage();
    }

    public function render()
    {
    $query = User::query()
    ->with('roles');

if ($this->busqueda) {

    $busqueda = mb_strtolower($this->busqueda);

    $query->where(function ($q) use ($busqueda) {

        $q->whereRaw(
            'LOWER(nombre_completo) LIKE ?',
            ["%{$busqueda}%"]
        )
        ->orWhereRaw(
            'LOWER(email) LIKE ?',
            ["%{$busqueda}%"]
        )
        ->orWhereRaw(
            'LOWER(username) LIKE ?',
            ["%{$busqueda}%"]
        );

    });
}

if ($this->rol) {
    $query->whereHas('roles', function ($q) {
        $q->where('name', $this->rol);
    });
}

if ($this->verificado) {
    $query->where('is_verified', $this->verificado);
}

$users = $query
    ->orderBy('id', 'asc')
    ->paginate(10);

return view('livewire.users', [
    'users' => $users,
]);
    }
}