<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Level;
use AppBundle\Form\LevelType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Version("v2")
 */
class V2LevelsController extends FOSRestController
{
    /**
     * @Rest\View(statusCode=400)
     */
    public function postLevelsAction(Request $request)
    {
        $level = new Level();

        $form = $this->createForm(new LevelType(), $level);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($level);
            $em->flush();

            return $this->routeRedirectView('get_level', array(
                'version' => 'v2',
                'level' => $level->getId())
            );
        }
    }

    /**
     * @Rest\View()
     */
    public function getLevelsAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Level');
        $data = $repository->findAll();

        return $data;
    }

    /**
     * @Rest\View(statusCode=400)
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

            return $this->routeRedirectView('get_level', array(
                'version' => 'v2',
                'level' => $level->getId())
            );
        }
    }

    /**
     * @Rest\View()
     */
    public function deleteLevelAction(Level $level)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($level);
        $em->flush($level);
    }

    /**
     * @Rest\View()
     */
    public function getLevelAction(Level $level)
    {
        return $level;
    }
}

