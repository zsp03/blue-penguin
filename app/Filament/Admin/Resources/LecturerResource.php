<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LecturerResource\Pages;
use App\Filament\Admin\Resources\LecturerResource\RelationManagers;
use App\Models\Lecturer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LecturerResource extends Resource
{
    protected static ?string $model = Lecturer::class;

    protected static ?string $recordTitleAttribute = 'name';
    public static function getPluralLabel(): ?string
    {
        return (__('Lecturer'));
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            '' => $record->nip,
        ];
    }

    protected static ?string $navigationIcon = 'phosphor-chalkboard-teacher';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->heading(__('Lecturer Data'))
                            ->translateLabel()
                            ->collapsible()
                            ->description(__('Enter the Lecturer information here'))
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->translateLabel()
                                    ->required(),
                                Forms\Components\TextInput::make('nip')
                                    ->label('NIP')
                                    ->required()
                                    ->maxLength(255),
                            ])->columns(2),

                        Forms\Components\Section::make()
                            ->heading(__('Profile Picture'))
                            ->translateLabel()
                            ->description(__('Upload or enter the URL of the Lecturer photo'))
                            ->collapsible()
                            ->schema([
                                Forms\Components\Tabs::make()
                                    ->tabs([
                                        Forms\Components\Tabs\Tab::make('Upload')
                                            ->translateLabel()
                                            ->schema([
                                                Forms\Components\FileUpload::make('image')
                                                    ->translateLabel()
                                                    ->label('')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->directory('lecturer-images')
                                                    ->reactive()
                                                    ->afterStateUpdated(function (Set $set, $state) {
                                                        $set('image_url', Storage::disk()->url($state->getRealPath()));
                                                    }),
                                            ]),
                                        Forms\Components\Tabs\Tab::make('URL')
                                            ->schema([
                                                Forms\Components\TextInput::make('image_url')
                                                    ->label('URL')
                                                    ->disabled(fn (Get $get) => !empty($get('image'))),
                                            ]),
                                    ])
                                    ->columnSpan('full'),
                            ])
                            ->columns(1),
                        Forms\Components\Section::make()
                            ->heading(__('Related User'))
                            ->translateLabel()
                            ->collapsed()
                            ->collapsible()
                            ->description(__('If lecturer have account, Link the account here'))
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('')
                                    ->relationship('user', 'name')
                                    ->live()
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('name', User::find((int)$state)->name))
                            ]),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => fn (?Lecturer $record) => $record === null ? 3 : 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('Created at')
//                            ->label(__('Created at'))
                            ->translateLabel()
                            ->content(fn (Lecturer $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('Updated at')
//                            ->label(__('Last modified at'))
                            ->translateLabel()
                            ->content(fn (Lecturer $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Lecturer $record) => $record === null),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Medium)
                    ->weight(\Filament\Support\Enums\FontWeight::Medium)
                    ->icon(fn (Lecturer $record) => $record->image_url ?: \asset('assets/images/default_avatar.jpg'))
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->copyable()
                    ->searchable(),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListLecturers::route('/'),
            'create' => Pages\CreateLecturer::route('/create'),
            'edit' => Pages\EditLecturer::route('/{record}/edit'),
        ];
    }
}
