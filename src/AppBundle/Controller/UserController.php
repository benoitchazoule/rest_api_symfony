<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Form\Type\UserType;
use AppBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @ApiDoc(
     *    description="Récupère la liste des utilisateurs de l'application",
     *    output= { "class"=User::class, "collection"=true, "groups"={"user"} }
     * )
     *
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users")
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->findAll();
        /* @var $users User[] */

        
        return $users;
    }
    
    
    /**
     * @ApiDoc(
     *    description="Récupère un utilisateur grace à son identifiant",
     *    output= { "class"=User::class, "collection"=false, "groups"={"user"} },
     *    statusCodes = {
     *        200 = "Requete traitée avec succès",
     *        404 = "Utilisateur non trouvé"
     *    }
     * )
     *
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users/{id}")
     */
    public function getUserAction(Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->find($request->get('id'));
        /* @var $user User */

        if (empty($user)) {
            return $this->userNotFound();
        }
        

        return $user;
    }
    
    
    /**
     * @ApiDoc(
     *    description="Créé un utilisateur dans l'application",
     *    input={"class"=UserType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Création avec succès",
     *        400 = "Formulaire invalide"
     *    },
     *    responseMap={
     *         201 = {"class"=User::class, "groups"={"user"}},
     *         400 = { "class"=UserType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"user"})
     * @Rest\Post("/users")
     */
    public function postUsersAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $encoder = $this->get('security.password_encoder');
            // le mot de passe en clair est encodé avant la sauvegarde
            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);
            
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }
    
    
    /**
     * @ApiDoc(
     *    description="Supprime un utilisateur",
     *    statusCodes = {
     *        204 = "Suppression effectuée avec succès",
     *        404 = "Utilisateur non trouvé"
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT, serializerGroups={"user"})
     * @Rest\Delete("/users/{id}")
     */
    public function removeUserAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('AppBundle:User')
                    ->find($request->get('id'));
        /* @var $place Place */

        if ($user) {
            $em->remove($user);
            $em->flush();
        }
    }
    
    
    /**
     * @ApiDoc(
     *    description="Mise à jour totale d'un utilisateur",
     *    input={"class"=UserType::class, "name"=""},
     *    statusCodes = {
     *        200 = "Mise à jour effectuée avec succès",
     *        400 = "Formulaire invalide",
     *        404 = "Utilisateur non trouvé"
     *    },
     *    responseMap={
     *         200 = {"class"=User::class, "groups"={"user"}},
     *         400 = { "class"=UserType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Put("/users/{id}")
     */
    public function updateUserAction(Request $request)
    {
        return $this->updateUser($request, true);
    }
    
    
    /**
     * @ApiDoc(
     *    description="Mise à jour partielle d'un utilisateur",
     *    input={"class"=UserType::class, "name"=""},
     *    statusCodes = {
     *        200 = "Mise à jour effectuée avec succès",
     *        400 = "Formulaire invalide",
     *        404 = "Utilisateur non trouvé"
     *    },
     *    responseMap={
     *         200 = {"class"=User::class, "groups"={"user"}},
     *         400 = { "class"=UserType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Patch("/users/{id}")
     */
    public function patchUserAction(Request $request)
    {
        return $this->updateUser($request, false);
    }
    
    
    /**
     * @ApiDoc(
     *    description="Récupère la liste des lieux correspondants aux préférences de l'utilisateur",
     *    output= { "class"=Place::class, "collection"=true, "groups"={"place"} },
     *    statusCodes = {
     *        200 = "Requete traitée avec succès",
     *        404 = "Utilisateur non trouvé"
     *    }
     * )
     *
     * @Rest\View(serializerGroups={"place"})
     * @Rest\Get("/users/{id}/suggestions")
     */
    public function getUserSuggestionsAction(Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->find($request->get('id'));
        /* @var $user User */

        if (empty($user)) {
            return $this->userNotFound();
        }

        $suggestions = [];

        $places = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Place')
                ->findAll();

        foreach ($places as $place) {
            if ($user->preferencesMatch($place->getThemes())) {
                $suggestions[] = $place;
            }
        }

        return $suggestions;
    }


    
    private function updateUser(Request $request, $clearMissing)
    {
        $user = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user User */

        if (empty($user)) {
            return $this->userNotFound();
        }

        if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = []; // Le groupe de validation par défaut de Symfony est Default
        }

        $form = $this->createForm(UserType::class, $user, $options);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            // Si l'utilisateur veut changer son mot de passe
            if (!empty($user->getPlainPassword())) {
                $encoder = $this->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encoded);
            }
            
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }
    
    
    private function userNotFound()
    {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('User not found');
    }
}