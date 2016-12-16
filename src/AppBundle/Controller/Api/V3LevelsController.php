<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Level;
use AppBundle\Entity\Task;
use AppBundle\Form\LevelType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Version("v3")
 */
class V3LevelsController extends FOSRestController
{
    /**
     * @Rest\View(statusCode=400)
     */
    public function postLevelsAction(Request $request, Task $task)
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
                'version' => 'v3',
                'level' => $level->getId())
            );
        }
    }

    /**
     * @Rest\View()
     */
    public function getLevelsAction(Task $task)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Level');
        $data = $repository->findAll();
    }

    /**
     * @Rest\View(statusCode=400)
     */
    public function putLevelAction(Request $request, Task $task, Level $level)
    {
        $form = $this->createForm(new LevelType(), $level);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($level);
            $em->flush();

            return $this->routeRedirectView('get_level', array(
                'version' => 'v3',
                'level' => $level->getId())
            );
        }
    }

    /**
     * @Rest\View()
     */
    public function deleteLevelAction(Task $task, Level $level)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($level);
        $em->flush($level);
    }

    /**
     * @Rest\View()
     */
    public function linkLevelAction(Task $task, Level $level)
    {
        $task->setLevel($level);

        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush($task);
    }

    /**
     * @Rest\View()
     */
    public function unlinkLevelAction(Task $task, Level $level)
    {
        $task->setLevel(null);

        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush($task);
    }

    /**
     * @Rest\View()
     */
    public function getLevelAction(Task $task, Level $level)
    {
        return $level;
    }
}

