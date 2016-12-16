<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Level;
use AppBundle\Form\LevelType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @Rest\Version("v1")
 */
class LevelsController extends Controller
{
    /**
     * @Route("/levels", name="api_levels_postLevel")
     * @Method("POST")
     */
    public function postLevelAction(Request $request)
    {
        $level = new Level();

        $form = $this->createForm(new LevelType(), $level);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($level);
            $em->flush();

            return new Response(null, 201, array('Content-Type' => 'application/json'));
        }

        return new Response(null, 400);
    }

    /**
     * @Route("/levels", name="api_levels_getLevels")
     * @Method("GET")
     */
    public function getLevelsAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Level');
        $levels = $repository->findAll();
        $json = $this->get('jms_serializer')->serialize($levels, 'json');

        return new Response($json, 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/levels/{id}", name="api_levels_putLevel")
     * @Method("PUT")
     */
    public function putLevelAction(Request $request, Level $level)
    {
        $form = $this->createForm(new LevelType(), $level);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($level);
            $em->flush();

            return new Response('', 204, array('Content-Type' => 'application/json'));
        }

        return new Response('', 400);
    }

    /**
     * @Route("/levels/{id}", name="api_levels_deletetLevel")
     * @Method("DELETE")
     */
    public function deleteLevelAction(Level $level)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($level);
        $em->flush($level);

        return new Response('', 204, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/levels/{id}", name="api_levels_getLevel")
     * @Method("GET")
     */
    public function getLevelAction(Level $level)
    {
        $json = $this->get('jms_serializer')->serialize($level, 'json');

        return new Response($json, 200, array('Content-Type' => 'application/json'));
    }

}

