<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    #[Route('/todo', name: 'app_to_do')]
    public function index(SessionInterface $session): Response
    {
        if(!$session->has('todos')){
            $todo = [
                "achat" => "acheter clé usb",

            ];
            $session->set('todos', $todo);
            $message='Bienvenu';
            $this->addFlash('welcome',$message);
        }
        return $this->render('to_do/index.html.twig', [
            'controller_name' => 'ToDoController',
        ]);
    }
    /**
     * @Route("/todo/add/{cle}/{element}");
     */
    public function add($cle, $element,SessionInterface $session)
    {
        if(!$session->has('todos')){
            $message='la liste n est pas encore initialisee ';
            $this->addFlash('warning',$message);
        }
        else{
            $todos = $session->get('todos');
            if(isset($todos[$cle])){
                $this->addFlash('erreur',"la valeur existe deja");
            }else{
                $todos[$cle] = $element;
                $session->set('todos', $todos);
                $this->addFlash("success", "done");
            }
        }
        return $this->redirect('/todo');
    }
    /**
     * @Route("/todo/delete/{cle}");
     */
    public function delete($cle,SessionInterface $session)
    {
        if(!$session->has('todos')){
            $message='la liste n est pas encore initialisee ';
            $this->addFlash('warning',$message);
        }
        else{
            $todos = $session->get('todos');
            if(!isset($todos[$cle])){
                $this->addFlash("error","la valeur n'existe pas");
            }else{
                unset($todos[$cle]);
                $session->set('todos', $todos);
                $this->addFlash("success", "done");
            }
        }
        return $this->redirect('/todo');
    }
    /**
     * @Route("/todo/reset");
     */
    public function reset(SessionInterface $session)
    {
        if(!$session->has('todos')){
            $message='la liste n est pas encore initialisee ';
            $this->addFlash('warning',$message);
        }
        else{
            $todos = $session->get('todos');
            $session->clear();
        }
        return $this->redirect('/todo');
    }
}
