<?php

declare(strict_types=1);

namespace Contact\Controller;

use Contact\Form\ContactForm;
use Contact\Model\Contact;
use Contact\Model\ContactTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    private ContactTable $table;

    public function __construct(ContactTable $table)
    {
        $this->table = $table;
    }

    public function indexAction(): ViewModel
    {
        return new ViewModel([
            'contacts' => $this->table->fetchAll(),
        ]);
    }

    public function addAction(): ViewModel|array
    {
        $form = new ContactForm();
        $form->get('submit')->setValue('Hinzufügen');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $contact = new Contact();
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $contact->exchangeArray($form->getData());
        $this->table->saveContact($contact);

        return $this->redirect()->toRoute('contact');
    }

    public function editAction(): ViewModel|array
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('contact', ['action' => 'add']);
        }

        try {
            $contact = $this->table->getContact($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('contact');
        }

        $form = new ContactForm();
        $form->bind($contact);
        $form->get('submit')->setValue('Aktualisieren');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return [
                'id' => $id,
                'form' => $form,
            ];
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return [
                'id' => $id,
                'form' => $form,
            ];
        }

        $contact->exchangeArray($form->getData());
        $this->table->saveContact($contact);

        return $this->redirect()->toRoute('contact');
    }

    public function deleteAction(): ViewModel|array
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('contact');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del', 'Nein');

            if ($del === 'Ja') {
                $this->table->deleteContact($id);
            }

            return $this->redirect()->toRoute('contact');
        }

        return [
            'id' => $id,
            'contact' => $this->table->getContact($id),
        ];
    }
}
