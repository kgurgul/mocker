<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Header;
use AppBundle\Entity\Mock;
use AppBundle\Form\Type\MockType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $mock = new Mock();
        $header = new Header();
        $mock->addHeader($header);
        $header->setMock($mock);
        $form = $this->createForm(new MockType(), $mock);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($mock);
            $em->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
