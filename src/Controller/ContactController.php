<?php


namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController
 * @package App\Controller
 * @Route("/api/contacts", name="contact_api")
 */
class ContactController extends ApiController
{
    /**
     * @param ContactRepository $contactRepository
     * @return JsonResponse
     * @Route("/", name="index", methods={"GET"})
     */
    public function getContacts(ContactRepository $contactRepository){
        $data = $contactRepository->findAll();
        return $this->response($data);
    }

    /**
     * @param int $id
     * @param ContactRepository $contactRepository
     * @return JsonResponse
     * @Route("/show/{id}", name="show", methods={"GET"})
     */
    public function getContact(int $id, ContactRepository $contactRepository){
        $data = $contactRepository->findBy([
            'id' => $id
        ]);
        return $this->response($data);
    }

    /**
     * @param int $id
     * @param ContactRepository $contactRepository
     * @return JsonResponse
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function deleteContact(int $id, ContactRepository $contactRepository){
        $data = $contactRepository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        return $this->response([]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @param ContactRepository $contactRepository
     * @return JsonResponse
     * @Route("/update/{id}", name="update", methods={"PUT"})
     */
    public function updateContact(Request $request, int $id, ContactRepository $contactRepository){

        $data = $contactRepository->find($id);

        $request = $this->transformJsonBody($request);
        $attributes = $request->request->all();
        $name = $attributes['name'];
        $surname = $attributes['surname'];
        $phone = $attributes['phone'];

        $data->setName($name);
        $data->setSurname($surname);
        $data->setPhone($phone);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return $this->response([]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/store", name="store", methods={"POST"})
     */
    public function addContact(Request $request){

        $em = $this->getDoctrine()->getManager();
        $request = $this->transformJsonBody($request);
        $attributes = $request->request->all();
        $name = $attributes['name'];
        $surname = $attributes['surname'];
        $phone = $attributes['phone'];

        if (empty($name) || empty($surname) || empty($phone)){
            return $this->respondValidationError("Invalid Name or Surname or Phone");
        }

        $contact = new Contact();
        $contact->setName($name);
        $contact->setSurname($surname);
        $contact->setPhone($phone);
        $em->persist($contact);
        $em->flush();

        return $this->respondWithSuccess(sprintf('Contact %s successfully created', $contact->getName() ." ". $contact->getSurname()));
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