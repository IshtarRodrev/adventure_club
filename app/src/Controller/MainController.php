<?php

namespace App\Controller;

use App\Form\CalcArgumentsType;
use App\Helper\Calculation;
use App\Enum\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main_calc')]
    public function index(RequestStack $requestStack): Response
    {
        $prevExpression = $requestStack->getSession()->get('expr') ?? null;

        $calculation = new Calculation();
        $request = $requestStack->getCurrentRequest();

        $form = $this->createForm(CalcArgumentsType::class, $calculation, ['prevExpression' => $prevExpression]);
        $form->handleRequest($request);
        $result = $requestStack->getSession()->get('result');
        $requestStack->getSession()->remove('result');

        if ($form->isSubmitted() && $form->isValid()) {

            $calculation = $form->getData();
            if ($prevExpression) {
                $calculation->setArg1($prevExpression);
            }

            if ($form->get('next')->isClicked()) {
                $requestStack->getSession()->set('expr', $calculation);

                return $this->redirect($request->getUri());
            } elseif ($form->get('calc')->isClicked()) {

                $requestStack->getSession()->remove('expr');
                $requestStack->getSession()->set('result', $calculation->getExpression());

                return $this->redirect($request->getUri());
            }
        }
        return $this->renderForm('calculator/index.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form,
            'result' => $result,
            'prevExpression' => $prevExpression,
        ]);
    }
}
