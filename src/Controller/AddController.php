<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use App\Form\AppType;
use App\Entity\App;

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

        $app = new App();
        
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
            if(PHP_OS == "WINNT") {
                //version windows
                chdir('../vendor/bin');
                $phpdumpcheck = `var-dump-check "$project_name"`;
            }else {
                //version linux
                $phpdumpcheck = `./../vendor/bin/var-dump-check "$project_name"`;
            }

            //Insertion des données (liens)
            $app->setAppGitLink($url);
            $app->setAppTestDate(new \DateTime('now'));
            $app->setAppPhpVer(`php -r 'echo PHP_VERSION;'`);


            //test doublons (liens)
             if ($url !== $app->getAppGitLink($url)){
            
                $save = $this->getDoctrine()->getManager();

                $save->persist($app);

                $save->flush();
            } else {
               //return new Response ("Lien existant");
            }
            return new Response('<pre>'.$phpcheckstyle.$phpdumpcheck.'</pre>');
        }
        
        return $this->render('add/index.html.twig', [
            'controller_name' => 'Add Controller',
            'controller_path' => realpath("."),
            'form' => $form->createView()
        ]);
    }
}
