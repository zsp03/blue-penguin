<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
use App\Filament\Resources\PublicationResource\RelationManagers;
use App\Filament\Resources\PublicationResource\Widgets\PublicationStats;
use App\Filament\Tables\Columns\AuthorsList;
use App\Models\Publication;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Utama')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->columnSpan('full')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('year')
                                    ->numeric(),
                                Forms\Components\Select::make('type')
                                    ->required()
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->options([
                                        'jurnal' => 'Jurnal',
                                        'prosiding' => 'Prosiding',
                                        'penelitian' => 'Penelitian',
                                        'pengabdian' => 'Pengabdian',
                                    ]),
                                Forms\Components\TextInput::make('total_funds')
                                    ->prefix('Rp.')
                                    ->numeric()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('fund_source')
                                    ->maxLength(255),
                            ])
                            ->collapsible()
                            ->columns(2),
                        Forms\Components\Section::make('Informasi Tambahan')
                        ->schema([
                            Forms\Components\TextInput::make('link')
                                ->label('Link Bukti')
                                ->columnSpan('full')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('citation')
                                ->numeric()
                                ->maxLength(255),
                            Forms\Components\Select::make('scale')
                                ->label('Skala')
                                ->native(false)
                                ->options([
                                    'Nasional' => 'Nasional',
                                    'Internasional' => 'Internasional',
                                ]),
                        ])
                            ->columns(2)
                            ->collapsible(),
                    ])->columnSpan(['lg' => fn (?Publication $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Publication $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Publication $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Publication $record) => $record === null),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    })
                    ->searchable(),
                AuthorsList::make('lecturers')
                    ->label('Tim Dosen Peneliti'),
                TextColumn::make('students.name')
                    ->label('Mahasiswa Terlibat')
                    ->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('year')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state)))
                    ->badge()
                    ->colors([
                        'success' => 'jurnal',
                        'gray' => 'prosiding',
                        'violet' => 'pengabdian',
                        'info' => 'penelitian',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('scale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_funds')
                    ->label('Total Dana')
                    ->prefix('Rp. ')
                    ->numeric(0,'.',','),
                Tables\Columns\TextColumn::make('fund_source')
                    ->label('Sumber Dana')
                    ->searchable(),
                Tables\Columns\TextColumn::make('citation'),
                Tables\Columns\ViewColumn::make('link')
                    ->label('Bukti')
                    ->view('filament.tables.columns.click-here'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LecturerRelationManager::class,
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PublicationStats::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}
