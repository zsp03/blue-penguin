<?php

namespace App\Filament\Publication\Resources;

use App\Enums\HakiStatus;
use App\Enums\PublicationScale;
use App\Filament\Publication\Resources\HakiResource\Pages;
use App\Filament\Publication\Resources\HakiResource\RelationManagers;
use App\Filament\Tables\Columns\AuthorsList;
use App\Models\Haki;
use Closure;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class HakiResource extends Resource
{
    protected static ?string $model = Haki::class;
    protected static ?string $navigationIcon = 'phosphor-medal';
    protected static ?int $navigationSort = 3;
    protected static ?string $recordTitleAttribute = 'name';
    public static function getNavigationGroup(): ?string
    {
        return __('Content');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Intellectual Properties');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $lecturerList = [];
        foreach ($record->lecturers as $lecturer){
            $lecturerList[] = $lecturer->name;
        }

        if (empty($lecturerList)){
            return [];
        }

        return array_combine(range(1, count($lecturerList)), array_values($lecturerList));
    }

    public static function getEloquentQuery(): Builder
    {
        $panelId = Filament::getCurrentPanel()->getId();
        if ($panelId == 'publication') {
            return parent::getEloquentQuery()->whereHas('lecturers', function (Builder $query) {
                return $query
                    ->where('nip', auth()->user()->lecturer?->nip);
            });
        }
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->heading(__('General Information'))
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->translateLabel()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('type')
                                            ->label(__('Type of Invention'))
                                            ->maxLength(255),
                                        Forms\Components\Select::make('scale')
                                            ->translateLabel()
                                            ->native(false)
                                            ->options(PublicationScale::class),
                                        Forms\Components\TextInput::make('year')
                                            ->translateLabel()
                                            ->default(now()->year)
                                            ->placeholder(now()->year)
                                            ->numeric()
                                            ->minValue(0),
                                    ])
                                    ->columns(3),
                            ])
                            ->collapsible(),
                        Forms\Components\Section::make()
                            ->heading(__('Inventors Information'))
                            ->schema([
                                Forms\Components\Select::make('inventors')
                                    ->label(__('Inventors'))
                                    ->multiple()
                                    ->relationship('lecturers', titleAttribute: 'name'),
                                Forms\Components\Select::make('faculty_id')
                                    ->label(__('Faculty'))
                                    ->multiple()
                                    ->preload()
                                    ->relationship('faculties', titleAttribute: 'name'),
                            ])
                            ->collapsible(),
                        Forms\Components\Section::make()
                            ->heading(__("Intellectual Property Information"))
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('haki_type')
                                            ->translateLabel()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('status')
                                            ->native(false)
                                            ->options(HakiStatus::class),
                                    ])
                                    ->columns(2),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('registration_no')
                                            ->translateLabel()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('haki_no')
                                            ->translateLabel()
                                            ->maxLength(255),
                                    ])
                                    ->columns(2),
                                Forms\Components\TextInput::make('registered_at')
                                    ->translateLabel()
                                    ->maxLength(255),

                            ])
                            ->collapsible(),
                        Forms\Components\Section::make()
                            ->heading(__('Proof of Intellectual Property'))
                            ->schema([
                                Forms\Components\Tabs::make('')
                                    ->tabs([
                                        Forms\Components\Tabs\Tab::make('upload')
                                            ->schema([
                                                Forms\Components\FileUpload::make('filename')
                                                    ->label('')
                                                    ->live()
                                                    ->directory('proof-ip')
                                            ]),
                                        Forms\Components\Tabs\Tab::make('link')
                                            ->schema([
                                                Forms\Components\TextInput::make('link')
                                                    ->maxLength(2000),
                                            ]),
                                    ]),
                            ]),

                        Forms\Components\Section::make()
                            ->heading(__('Invention Output'))
                            ->schema([
                                Forms\Components\Textarea::make('output')
                                    ->label('')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => fn (?Haki $record) => $record === null ? 3 : 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label(__('Created at'))
                            ->content(fn (Haki $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label(__('Last modified at'))
                            ->content(fn (Haki $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Haki $record) => $record === null),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchPlaceholder('Search by IPs, Type, or Year')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->description(function (Haki $record): Htmlable {
                        $haki_type = $record->haki_type->getLabel();
                        return new HtmlString("<span class='text-xs'>" .
                            "$haki_type"
                            . ' | ' .
                            "$record->type"
                            . ' | ' .
                            "$record->year" .
                            "</span>");
                    }, position: 'above')
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Small)
                    ->limit(60)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('haki_type', 'like', "%{$search}%")
                            ->orWhere('year', "%{$search}%");
                    }),
                AuthorsList::make('lecturers')
                    ->label(__('Inventors')),
                Tables\Columns\TextColumn::make('scale')
                    ->translateLabel()
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state)))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state)))
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('faculties.name')
                    ->bulleted()
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('haki_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registered_at')
                    ->searchable(),
                Tables\Columns\TextColumn::make('link')
                    ->label('')
                    ->view('filament.tables.columns.click-here'),
                Tables\Columns\TextColumn::make('filename')
                    ->label('')
                    ->view('filament.tables.columns.attachment'),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHakis::route('/'),
            'create' => Pages\CreateHaki::route('/create'),
            'edit' => Pages\EditHaki::route('/{record}/edit'),
        ];
    }
}
