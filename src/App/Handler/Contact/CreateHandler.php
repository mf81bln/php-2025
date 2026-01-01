<?php

declare(strict_types=1);

namespace App\Handler\Contact;

use App\Model\Contact;
use App\Model\ContactTable;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreateHandler implements RequestHandlerInterface
{
    public function __construct(
        private TemplateRendererInterface $template,
        private ContactTable $contactTable,
        private UrlHelper $urlHelper
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $error = null;
        $data = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'notes' => '',
        ];

        if ($request->getMethod() === 'POST') {
            $postData = $request->getParsedBody();
            $data = array_merge($data, $postData);

            if (empty($postData['name'])) {
                $error = 'Name ist erforderlich';
            } else {
                $contact = new Contact();
                $contact->exchangeArray($postData);
                $this->contactTable->saveContact($contact);

                return new RedirectResponse($this->urlHelper->generate('contact.list'));
            }
        }

        return new HtmlResponse($this->template->render('app::contact/create', [
            'data' => $data,
            'error' => $error,
        ]));
    }
}
