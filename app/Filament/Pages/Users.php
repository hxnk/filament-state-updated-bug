<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;

class Users extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.users';

    protected int $timesCalled = 0;

    protected function getTableQuery(): Builder
    {
        return User::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('email'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('some_action')
                ->form([
                    TextInput::make('some_input')
                        ->required()
                        ->afterStateUpdated(fn () => $this->timesCalled++)
                ])
                ->action(function () {
                    Notification::make('some_notification')
                        ->title("afterStateUpdated() was called $this->timesCalled times")
                        ->send();
                })
        ];
    }
}
