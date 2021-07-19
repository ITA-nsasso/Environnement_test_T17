<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use App\Form\AppType;

class AddController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        return $this->render('add/test.html.twig', [
            'controller_name' => 'AddController',
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $form = $this->createForm(AppType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form["url"]->getData());
            $url = $form["app_GitLink"]->getData();
            `git clone $url`;
            $url_explode = explode("/",$url);
            $project_name = substr(__DIR__,0,-14)."public".DIRECTORY_SEPARATOR.$url_explode[count($url_explode)-1];
            // var_dump($project_name);
            $phpcheckstyle = `php ../vendor/phpcheckstyle/phpcheckstyle/run.php --src "$project_name"` ;
            chdir('../vendor/bin');
            $phpdumpcheck = `var-dump-check "$project_name"`;
            return new Response('<pre>'.$phpcheckstyle.$phpdumpcheck.'</pre>');
        }

        return $this->render('add/index.html.twig', [
            'controller_name' => 'Add Controller',
            'controller_path' => realpath("."),
            'form' => $form->createView()
        ]);
    }
}
