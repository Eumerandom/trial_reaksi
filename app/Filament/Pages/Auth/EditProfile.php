<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getAvatarFormComponent(),
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function getAvatarFormComponent(): Component
    {
        return SpatieMediaLibraryFileUpload::make('avatar')
            ->label('Avatar')
            ->collection('profile_photos')
            ->disk('public')
            ->visibility('public')
            ->avatar()
            ->imageEditor()
            ->circleCropper()
            ->columnSpanFull();
    }
}
