<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use PHPCheckstyle;

use App\Form\AppType;
use App\Entity\App;

class AddController extends AbstractController
{
    /**
     * @Route("/", name="add")
     */
    public function add(Request $request) : Response
    {

        $app = new App();
        $form = $this->createForm(AppType::class);
        $regex = "/[a-zA-Z0-9_].git/m";

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form["url"]->getData());
            $url = $form["app_GitLink"]->getData();
            `git clone $url`;
            $url_explode = explode("/",$url);
            $project_name = substr(__DIR__,0,-14)."public".DIRECTORY_SEPARATOR.$url_explode[count($url_explode)-1];
            
            if(preg_match($regex,$project_name)) {
                $project_name = rtrim($project_name,".git");
            }
            
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
            $app->setAppPhpVer(PHP_VERSION);


            //test doublons (liens)
            //if ($url !== $app->getAppGitLink($url)){
            
                $save = $this->getDoctrine()->getManager();

                $save->persist($app);

                $save->flush();
            /* } else {
               //return new Response ("Lien existant");
            } */
            
            return $this->render('add/rapport.html.twig', [
                'rapports' => $phpcheckstyle.$phpdumpcheck
            ]);
        }
        
        return $this->render('add/index.html.twig', [
            'controller_name' => 'Add Controller',
            'controller_path' => realpath("."),
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/detail", name="detail")
     */
    public function detail(): Response
    {

        $options['format'] = "array"; // default format
        $formats = explode(',', $options['format']);
        $configFile = array(
            'indentation' => array(
                "type" => "spaces",
                "number" => 2
                )
            );
            
        $repository = $this->getDoctrine()->getRepository(App::class);

        $query = $repository->createQueryBuilder('app')
        ->select('app.app_GitLink')
        ->orderBy('app.app_pk','DESC')
        ->getQuery();
        $url = $query->setMaxResults(1)->getOneOrNullResult();

        $url_explode = explode("/",$url['app_GitLink']);
        $project_name = substr(__DIR__,0,-14)."public".DIRECTORY_SEPARATOR.$url_explode[count($url_explode)-1];
        $mysourcexplode = explode(',', $project_name);
        $style = new PHPCheckstyle\PHPCheckstyle($formats, "./checkstyle_result", $configFile, null, false, true);
        $style->processFiles($mysourcexplode, array());
        $detail = $style->_reporter->reporters[0]->outputFile;

        return $this->render('add/detail.html.twig', [
            'details' => $detail
        ]);
    }

}
