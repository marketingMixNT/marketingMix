<?php

namespace App\Models;

use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    // RELATIONS
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
    // FORMS

    public static function getForm(): array
    {
        return [
            TextInput::make('title')
                ->label('Tytuł')
                ->unique(ignoreRecord: true)
                ->required()
                ->minLength(3)
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
            TextInput::make('slug')
                ->label('Slug')
                ->readonly()
                ->required()
                ->minLength(3)
                ->maxLength(255),

            Hidden::make('user_id')
                ->required()
                ->default(
                    Filament::auth()->id()
                )
        ];
    }

    // METHODS
}