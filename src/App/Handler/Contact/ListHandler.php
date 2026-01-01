<?php

declare(strict_types=1);

namespace App\Handler\Contact;

use App\Model\ContactTable;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListHandler implements RequestHandlerInterface
{
    public function __construct(
        private TemplateRendererInterface $template,
        private ContactTable $contactTable
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $contacts = $this->contactTable->fetchAll();

        return new HtmlResponse($this->template->render('app::contact/list', [
            'contacts' => $contacts,
        ]));
    }
}
