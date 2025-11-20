<?php

declare(strict_types=1);

namespace App\Actions\Contacts;

use App\DTOs\ContactDTO;
use App\Models\Contact;
use App\Services\ContactService;

final readonly class CreateContactAction
{
    public function __construct(
        private ContactService $contactService,
    ) {
    }

    public function execute(ContactDTO $dto): Contact
    {
        return $this->contactService->create($dto);
    }
}
