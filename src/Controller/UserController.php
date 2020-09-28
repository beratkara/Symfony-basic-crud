<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/api", name="rest_api")
 */
class UserController extends AbstractController
{
    /**
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @Route("/users", name="users", methods={"GET"})
     */
    public function getUsers(UserRepository $userRepository){
        $data = $userRepository->findAll();
        return $this->response($data);
    }

    /**
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @Route("/addUser", name="addUser", methods={"POST"})
     */
    public function addUsers(UserRepository $userRepository){
        $data = $userRepository->findAll();
        return $this->response($data);
    }

    /**
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @Route("/getProfile", name="getProfile", methods={"GET"})
     */
    public function getProfile(UserRepository $userRepository){
        $current_user = $this->getUser();

        $data = $userRepository->findBy([
            'email' => $current_user->getUsername()
        ]);

        return $this->response($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/setProfile", name="setProfile", methods={"POST"})
     */
    public function setProfile(Request $request){
        $current_user = $this->getUser();

        $request = $this->transformJsonBody($request);
        $attributes = $request->request->all();

        if ($attributes['password'])
        {

        }
        dd($attributes);

        return $this->response($data);
    }

    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param $status
     * @param array $headers
     * @return JsonResponse
     */
    public function response($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }

    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}