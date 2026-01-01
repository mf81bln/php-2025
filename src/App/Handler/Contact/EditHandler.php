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

class EditHandler implements RequestHandlerInterface
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

        $error = null;
        $data = $contact->getArrayCopy();

        if ($request->getMethod() === 'POST') {
            $postData = $request->getParsedBody();
            $data = array_merge($data, $postData);

            if (empty($postData['name'])) {
                $error = 'Name ist erforderlich';
            } else {
                $contact->exchangeArray(array_merge($postData, ['id' => $id]));
                $this->contactTable->saveContact($contact);

                return new RedirectResponse($this->urlHelper->generate('contact.list'));
            }
        }

        return new HtmlResponse($this->template->render('app::contact/edit', [
            'id' => $id,
            'data' => $data,
            'error' => $error,
        ]));
    }
}
