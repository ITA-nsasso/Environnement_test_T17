<?php

namespace App\Controller;

use App\Entity\App;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use PHPCheckstyle;

class StoryController extends AbstractController
{
    /**
     * @Route("/story", name="story")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(App::class);
        
        return $this->render('story/index.html.twig', [
            'stories' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/detail/{id}", name="show")
     */
    public function show($id): Response
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
            ->select('app.app_GitLink', 'app.app_pk')
            ->andWhere('app.app_pk = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $url = $query->setMaxResults(1)->getOneOrNullResult();

        $url_explode = explode("/",$url['app_GitLink']);
        $project_name = substr(__DIR__,0,-14)."public".DIRECTORY_SEPARATOR.$url_explode[count($url_explode)-1];
        $mysourcexplode = explode(',', $project_name);
        $style = new PHPCheckstyle\PHPCheckstyle($formats, "./checkstyle_result", $configFile, null, false, true);
        $style->processFiles($mysourcexplode, array());
        $detail = $style->_reporter->reporters[0]->outputFile;

        return $this->render('story/detailshow.html.twig', [
            'show' => $repository->find($id),
            'detail' => $detail
        ]);
    }
}
