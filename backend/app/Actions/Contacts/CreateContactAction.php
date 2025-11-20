<?php

declare(strict_types=1);

namespace App\Actions\Contacts;

use App\DTOs\ContactDTO;
use App\Models\Contact;
use App\Services\ContactService;

/**
 * Action responsável por criar uma nova mensagem de contato no sistema.
 */
final readonly class CreateContactAction
{
    public function __construct(
        private ContactService $contactService,
    ) {
    }

    /**
     * Executa a criação de uma nova mensagem de contato.
     *
     * @param ContactDTO $dto Dados da mensagem a ser criada
     * @return Contact Mensagem criada
     */
    public function execute(ContactDTO $dto): Contact
    {
        return $this->contactService->create($dto);
    }
}
