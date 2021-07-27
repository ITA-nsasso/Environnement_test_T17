<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

# Import manuel des composants nécessaires au controlleur
use Symfony\Component\HttpFoundation\Request;
use PHPCheckstyle;
use App\Form\AppType;
use App\Entity\App;

class AddController extends AbstractController
{

    # Fonction de la page d'accueil,
    /**
     * @Route("/", name="add")
     */
    public function add(Request $request) : Response
    {

        # Génération du formulaire
        $app = new App();
        $form = $this->createForm(AppType::class);

        # regex pour vérifier sorte de lien git. Utilisé plus tard
        $regex = "/[a-zA-Z0-9_].git/m";

        $form->handleRequest($request);

        # As-t-on un formulaire soumis pour charger la vue ? Si oui ;
        if ($form->isSubmitted() && $form->isValid()) {

            # Récupérer le lien depuis le formulaire et cloner le projet en local
            $url = $form["app_GitLink"]->getData();

            if(`git ls-remote $url` ==  null) {
                throw $this->createNotFoundException('Le lien n\'est pas valide');
            }

            if(preg_match($regex,$url)) {
                $url = rtrim($url,".git");
            }
            
            `git clone $url`;
            
            # Récupérer le nom du projet git
            $url_explode = explode("/",$url);
            $project_name = substr(__DIR__,0,-14)."public".DIRECTORY_SEPARATOR.$url_explode[count($url_explode)-1];
            
            # le lien git contenait t'il un ".git" à la fin de la chaîne ? si oui, l'enlever
            
            # Lancer les outils de test sur le projet téléchargé :
            # - D'abord l'outil phpcheckstyle
            $phpcheckstyle = `php ../vendor/phpcheckstyle/phpcheckstyle/run.php --src "$project_name"` ;
            # - Puis l'outil var-dump-check, avec une spécificité pour l'OS Windows
            if(PHP_OS == "WINNT") {
                # Version Windows
                chdir('../vendor/bin');
                $phpdumpcheck = `var-dump-check "$project_name"`;
            }else {
                # Version linux / Unix
                $phpdumpcheck = `./../vendor/bin/var-dump-check "$project_name"`;
            }
            
            # Définition des données
            $app->setAppGitLink($url);
            $app->setAppTestDate(new \DateTime('now'));
            $app->setAppPhpVer(PHP_VERSION);
            
            # Insertion des données définies dans la bdd
            $save = $this->getDoctrine()->getManager();
            $save->persist($app);
            $save->flush();
            
            # Retourner la vue en passant en paramètres la sortie des outils
            return $this->render('add/rapport.html.twig', [
                'rapports' => $phpcheckstyle.$phpdumpcheck,
                'url' => $url_explode[count($url_explode)-1]
            ]);
        }
        
        # Si non, afficher le formulaire à remplir
        return $this->render('add/index.html.twig', [
            'controller_name' => 'Add Controller',
            'controller_path' => realpath("."),
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/detail/{url}", name="detail")
     */
    public function detail($url): Response
    {
        # Configuration des options pour l'affichage du résultat
        $options['format'] = "array"; // default format
        $formats = explode(',', $options['format']);
        $configFile = array(
            'indentation' => array(
                "type" => "spaces",
                "number" => 2
                )
            );
                        
            # Récupérer le nom du projet git
            $project_name = substr(__DIR__,0,-14)."public".DIRECTORY_SEPARATOR.$url;    

            # Le mettre en format de tableau
            $mysourcexplode = explode(',', $project_name);

            # Créer un objet PHPCheckstyle qui contiendra les résultats détaillés de l'analyse
            $style = new PHPCheckstyle\PHPCheckstyle($formats, "./checkstyle_result", $configFile, null, false, true);
            $style->processFiles($mysourcexplode, array());
            $detail = $style->_reporter->reporters[0]->outputFile;

            # Envoyer la partie qui nous intéresse de l'objet à la vue 
            return $this->render('add/detail.html.twig', [
                'details' => $detail,
            ]);
        }
        
    }
    