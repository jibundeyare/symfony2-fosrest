<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Level;
use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Version({"v1", "v2", "v3"})
 */
class TasksController extends FOSRestController
{
    public function postTasksAction(Request $request)
    {
        $task = new Task();

        $form = $this->createForm(new TaskType(), $task);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->routeRedirectView('get_task', array(
                'version' => 'v2',
                'task' => $task->getId())
            );
        }

        $view = $this->view(null, 400);

        return $this->handleView($view);
    }

    public function getTasksAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        $data = $repository->findAll();

        $view = $this->view($data);

        return $this->handleView($view);
    }

    public function putTaskAction(Request $request, Task $task)
    {
        $form = $this->createForm(new TaskType(), $task);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->routeRedirectView('get_task', array(
                'version' => 'v2',
                'task' => $task->getId())
            );
        }

        $view = $this->view(null, 400);

        return $this->handleView($view);
    }

    public function deleteTaskAction(Task $task)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush($task);

        $view = $this->view(null, 204);

        return $this->handleView($view);
    }

    public function getTaskAction(Task $task)
    {

        $view = $this->view($task);

        return $this->handleView($view);
    }
}

