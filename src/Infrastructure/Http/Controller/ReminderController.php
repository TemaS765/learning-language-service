<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\GetReminderUseCase;
use App\Application\UseCase\Request\UpdateReminderRequest;
use App\Application\UseCase\UpdateReminderUseCase;
use App\Domain\Exception\NotFoundException;
use App\Infrastructure\Form\Model\UpdateReminderFormModel;
use App\Infrastructure\Form\ReminderForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReminderController extends AbstractController
{
    #[Route('/reminder', name: 'show_reminder', methods: ['GET'])]
    public function show(GetReminderUseCase $useCase): Response
    {
        $reminder = $useCase();
        $formModel = new UpdateReminderFormModel();
        $formModel->setId($reminder->id);
        $formModel->setRepeatPeriod($reminder->repeatPeriod);
        $formModel->setChannelType($reminder->channelType);
        $formModel->setChannelId($reminder->channelId);
        $formModel->setIsActive($reminder->isActive);

        $form = $this->createForm(ReminderForm::class, $formModel);

        return $this->render('reminder/reminder.html.twig', ['form' => $form]);
    }

    #[Route('/reminder', name: 'update_reminder', methods: ['POST'])]
    public function update(Request $request, UpdateReminderUseCase $useCase): Response
    {
        $form = $this->createForm(ReminderForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UpdateReminderFormModel $formModel */
            $formModel = $form->getData();
            try {
                $request = new UpdateReminderRequest(
                    $formModel->getId(),
                    $formModel->getRepeatPeriod(),
                    $formModel->getChannelType(),
                    $formModel->getChannelId(),
                    $formModel->isActive()
                );
                $useCase($request);
            } catch (NotFoundException $exception) {
                $this->addFlash('notice', 'Не найдено напоминание');

                return $this->redirectToRoute('/');
            }
            $this->addFlash('success', 'Информация обновлена');

            return $this->redirectToRoute('show_reminder');
        }

        return $this->render('reminder/reminder.html.twig', ['form' => $form]);
    }
}
