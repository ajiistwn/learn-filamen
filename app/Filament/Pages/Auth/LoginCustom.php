<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Page;
use Filament\Pages\Auth\Login;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\ValidationException;

class LoginCustom extends Login
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getLoginComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
    protected function getLoginComponent(): Component
    {
        return TextInput::make('login')
            ->label(__('name / email'))
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1])
            ->placeholder(__('Enter your username or email'));
    }
    protected function getCredentialsFromFormData(array $data): array
    {
        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        return [
            $login_type => $data['login'],
            'password' => $data['password'],
        ];
    }
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }
}
