<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    public const TYPES = [
        'cocinado' => 'Cocinado',
        'sin_preparar' => 'Sin preparar',
        'articulo_general' => 'Articulo general',
    ];

    public const CATEGORIES = [
        'alimento' => 'Alimento',
        'limpieza' => 'Limpieza',
        'higiene' => 'Higiene',
        'mascotas' => 'Mascotas',
        'otro' => 'Otro',
    ];

    public const LOCATIONS = [
        'alacena' => 'Alacena',
        'refrigerador' => 'Refrigerador',
        'congelador' => 'Congelador',
        'comida_preparada' => 'Comida preparada',
        'otro' => 'Otro',
    ];

    public const STATUSES = [
        'disponible' => 'Disponible',
        'poco' => 'Poco',
        'terminado' => 'Terminado',
        'consumir_pronto' => 'Consumir pronto',
        'consumido' => 'Consumido',
        'desechar' => 'Desechar',
    ];

    protected $fillable = [
        'team_id',
        'nombre',
        'tipo',
        'categoria',
        'ubicacion',
        'estado',
        'fecha_preparacion',
        'consumir_antes',
        'faltante',
    ];

    protected function casts(): array
    {
        return [
            'fecha_preparacion' => 'date',
            'consumir_antes' => 'date',
            'faltante' => 'boolean',
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function freshness(): string
    {
        if (! $this->consumir_antes) {
            return 'Sin fecha';
        }

        if ($this->consumir_antes->isPast() && ! $this->consumir_antes->isToday()) {
            return 'Vencido';
        }

        if (now()->startOfDay()->diffInDays($this->consumir_antes, false) <= 2) {
            return 'Consumir pronto';
        }

        return 'Vigente';
    }
}
