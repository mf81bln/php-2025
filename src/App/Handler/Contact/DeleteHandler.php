<?php

declare(strict_types=1);

namespace App\Handler\Contact;

use App\Model\ContactTable;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

class DeleteHandler implements RequestHandlerInterface
{
    public function __construct(
        private TemplateRendererInterface $template,
        private ContactTable $contactTable,
        private UrlHelper $urlHelper
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');

        try {
            $contact = $this->contactTable->getContact($id);
        } catch (RuntimeException) {
            return new RedirectResponse($this->urlHelper->generate('contact.list'));
        }

        if ($request->getMethod() === 'POST') {
            $postData = $request->getParsedBody();

            if (($postData['confirm'] ?? '') === 'yes') {
                $this->contactTable->deleteContact($id);
            }

            return new RedirectResponse($this->urlHelper->generate('contact.list'));
        }

        return new HtmlResponse($this->template->render('app::contact/delete', [
            'id' => $id,
            'contact' => $contact,
        ]));
    }
}
